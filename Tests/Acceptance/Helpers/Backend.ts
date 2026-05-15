import { Page, expect, Browser, FrameLocator } from '@playwright/test';
import * as fs from 'fs';
import * as path from 'path';

export const BACKEND_USER = process.env.TYPO3_BACKEND_USER ?? 'admin';
export const BACKEND_PASSWORD = process.env.TYPO3_BACKEND_PASSWORD ?? 'admin1234';
export const AUTH_STATE_PATH = path.resolve(__dirname, '../../../.auth/storageState.json');

/**
 * Form context can be either Page or FrameLocator (iframe).
 * Both support .locator() and .getByRole() methods.
 */
export type FormContext = Page | FrameLocator;

/**
 * TYPO3 14 backend renders module content (including edit forms) inside an iframe.
 * Returns a FrameLocator for any iframe present, or the Page itself if no iframe exists.
 */
export async function getFormContext(page: Page): Promise<FrameLocator | Page> {
    // Generic iframe selector - matches any iframe on the page
    const iframe = page.locator('iframe').first();
    const hasIframe = await iframe.isVisible({ timeout: 2000 }).catch(() => false);

    if (hasIframe) {
        return page.frameLocator('iframe').first();
    }
    return page;
}

export async function login(page: Page): Promise<void> {
    await page.goto('/typo3/');

    // Check if already logged in
    const isLoggedIn = await page.locator('.scaffold, .t3js-topbar-navigation, [data-module-nav]').first().isVisible().catch(() => false);
    if (isLoggedIn) {
        return;
    }

    // Perform login
    await page.waitForSelector('#t3-username, input[name="username"]', { timeout: 10000 });
    await page.locator('#t3-username, input[name="username"]').first().fill(BACKEND_USER);
    await page.locator('#t3-password, input[name="password"]').first().fill(BACKEND_PASSWORD);
    await page.locator('#t3-login-submit, button[type="submit"]').first().click();

    // Wait for backend to load
    await expect(page.locator('.scaffold, .t3js-topbar-navigation, .module-docheader').first()).toBeVisible({ timeout: 15000 });

    // Additional wait for fully loaded
    await page.waitForTimeout(1000);
}

export async function loginAndSaveState(browser: Browser): Promise<void> {
    const authDir = path.dirname(AUTH_STATE_PATH);
    if (!fs.existsSync(authDir)) {
        fs.mkdirSync(authDir, { recursive: true });
    }
    const context = await browser.newContext();
    const page = await context.newPage();
    await login(page);
    await context.storageState({ path: AUTH_STATE_PATH });
    await context.close();
}

export async function navigateToList(page: Page, table: string, pid: number = 1): Promise<void> {
    // TYPO3 14 uses module identifier "web_list"
    await page.goto(`/typo3/module/web/list?id=${pid}&table=${table}`);
}

/**
 * Navigate to the create new record page and wait for the form inside the iframe
 */
export async function createRecord(page: Page, table: string, pid: number = 1): Promise<FrameLocator | Page> {
    await page.goto(`/typo3/record/edit?edit[${table}][${pid}]=new`);

    // Wait for any iframe to be present (TYPO3 wraps content in an iframe)
    await page.waitForSelector('iframe', {
        timeout: 15000,
        state: 'attached'
    }).catch(() => {});

    const ctx = await getFormContext(page);

    // Wait for form to load inside the context (iframe or page)
    await ctx.locator('.formengine-container, [data-formengine-field-name], form[name="editform"], input[name*="data["]').first()
        .waitFor({ state: 'visible', timeout: 15000 });

    // Additional wait for form to be fully initialized
    await page.waitForTimeout(1000);

    return ctx;
}

export async function saveRecord(page: Page, ctx?: FrameLocator | Page): Promise<void> {
    const context = ctx ?? (await getFormContext(page));

    console.log(`[saveRecord] BEFORE click: page.url()=${page.url()}`);
    for (const frame of page.frames()) {
        console.log(`[saveRecord] BEFORE click: frame.url()=${frame.url()}`);
    }

    const saveButton = context.getByRole('button', { name: /^Speichern$|^Save$/i }).first();
    let buttonFound = await saveButton.isVisible({ timeout: 3000 }).catch(() => false);

    console.log(`[saveRecord] role-based button found: ${buttonFound}`);

    if (!buttonFound) {
        const fallback = context.locator('[name="_savedok"], [name="_saveandclosedok"], button[name*="save"]').first();
        const fallbackVisible = await fallback.isVisible({ timeout: 3000 }).catch(() => false);
        console.log(`[saveRecord] fallback button found: ${fallbackVisible}`);
        if (!fallbackVisible) {
            throw new Error('No save button found in form');
        }
        await fallback.click();
    } else {
        await saveButton.click();
    }

    await page.waitForLoadState('networkidle', { timeout: 15000 }).catch(() => {});
    await page.waitForTimeout(2000);

    console.log(`[saveRecord] AFTER save: page.url()=${page.url()}`);
    for (const frame of page.frames()) {
        console.log(`[saveRecord] AFTER save: frame.url()=${frame.url()}`);
    }
}

/**
 * Find a record by its title using the TYPO3 List module.
 * This is a reliable fallback when extractSavedUid fails to read iframe DOM.
 */
export async function findRecordByTitle(page: Page, table: string, title: string, pid: number = 1): Promise<number | null> {
    await page.goto(`/typo3/module/web/list?id=${pid}&table=${table}`);
    await page.waitForTimeout(1500);

    const ctx = await getFormContext(page);

    // List rows have data-uid or data-table-uid attribute. Find row with matching title text.
    const uid = await page.evaluate(({ tableName, recordTitle }) => {
        const findInDoc = (doc: Document): number | null => {
            // Look for table rows with the record title
            const rows = doc.querySelectorAll(`tr[data-uid], tr[data-table="${tableName}"]`);
            for (const row of Array.from(rows)) {
                const text = (row as HTMLElement).textContent || '';
                if (text.includes(recordTitle)) {
                    const uid = (row as HTMLElement).getAttribute('data-uid');
                    if (uid) return parseInt(uid, 10);
                }
            }
            return null;
        };

        let result = findInDoc(document);
        if (result !== null) return result;

        const iframes = document.querySelectorAll('iframe');
        for (const iframe of Array.from(iframes)) {
            try {
                const doc = (iframe as HTMLIFrameElement).contentDocument;
                if (doc) {
                    result = findInDoc(doc);
                    if (result !== null) return result;
                }
            } catch {
                // ignore
            }
        }
        return null;
    }, { tableName: table, recordTitle: title }).catch(() => null);

    return uid;
}

/**
 * Extract the UID of a freshly saved record by inspecting DOM inputs and frame URLs.
 */
export async function extractSavedUid(page: Page, table: string): Promise<number | null> {
    // Debug: log all frame URLs
    console.log(`[extractSavedUid] table=${table}, page.url()=${page.url()}`);
    for (const frame of page.frames()) {
        console.log(`[extractSavedUid]   frame.url()=${frame.url()}`);
    }

    // Method 1: page.evaluate to find data[table][UID] in main DOM and same-origin iframes
    const evalResult = await page.evaluate((tableName) => {
        const findInDoc = (doc: Document): { uid: number | null; sampleNames: string[] } => {
            const all = doc.querySelectorAll('[name]');
            const dataNames: string[] = [];
            for (const el of Array.from(all)) {
                const n = (el as HTMLInputElement).name || '';
                if (n.startsWith('data[')) dataNames.push(n);
            }
            for (const n of dataNames) {
                const m = n.match(new RegExp('data\\[' + tableName + '\\]\\[(\\d+)\\]'));
                if (m) return { uid: parseInt(m[1], 10), sampleNames: dataNames.slice(0, 5) };
            }
            return { uid: null, sampleNames: dataNames.slice(0, 5) };
        };

        const result = findInDoc(document);
        if (result.uid !== null) return result;

        const iframes = document.querySelectorAll('iframe');
        for (const iframe of Array.from(iframes)) {
            try {
                const doc = (iframe as HTMLIFrameElement).contentDocument;
                if (doc) {
                    const r = findInDoc(doc);
                    if (r.uid !== null) return r;
                    if (r.sampleNames.length > 0) result.sampleNames = r.sampleNames;
                }
            } catch {
                // ignore
            }
        }
        return result;
    }, table).catch((e) => ({ uid: null, sampleNames: [`ERROR: ${e}`] }));

    console.log(`[extractSavedUid] sample data[] names found:`, evalResult.sampleNames);

    if (evalResult.uid !== null) return evalResult.uid;

    // Method 2: Check page URL and iframe URLs for edit[table][UID]
    const escapedTable = table.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
    const urlPattern = new RegExp(`edit\\[${escapedTable}\\]\\[(\\d+)\\]=edit`);

    const pageMatch = page.url().match(urlPattern);
    if (pageMatch) return parseInt(pageMatch[1], 10);

    for (const frame of page.frames()) {
        const m = frame.url().match(urlPattern);
        if (m) return parseInt(m[1], 10);
    }

    return null;
}

/**
 * Select categories in TYPO3 14's category tree (treeitems, not checkboxes).
 */
async function selectCategoriesByTitle(ctx: FormContext, page: Page, titles: string[]): Promise<void> {
    if (titles.length === 0) return;

    const categoriesTab = ctx.getByRole('tab', { name: /Kategorien|Categories/i }).first();
    if (await categoriesTab.isVisible().catch(() => false)) {
        await categoriesTab.click();
        await page.waitForTimeout(800);
    }

    for (const title of titles) {
        const treeItem = ctx.getByRole('treeitem', { name: title, exact: true }).first();
        if (await treeItem.isVisible().catch(() => false)) {
            await treeItem.click().catch(() => {});
            await page.waitForTimeout(300);
        }
    }
}

export async function createCategory(page: Page, title: string, pid: number = 1): Promise<number | null> {
    const ctx = await createRecord(page, 'sys_category', pid);

    const titleField = ctx.locator('input[name*="[title]"], [data-formengine-input-name*="[title]"]').first();
    await expect(titleField).toBeVisible({ timeout: 5000 });
    await titleField.fill(title);

    await saveRecord(page, ctx);

    let uid = await extractSavedUid(page, 'sys_category');
    if (uid === null) {
        uid = await findRecordByTitle(page, 'sys_category', title, pid);
    }
    return uid;
}

export async function createAddressWithGeolocation(
    page: Page,
    title: string,
    street: string,
    zip: string,
    city: string,
    categoryTitles: string[] = [],
    pid: number = 1
): Promise<number | null> {
    const ctx = await createRecord(page, 'tx_gomapsext_domain_model_address', pid);

    // Fill basic fields
    await ctx.locator('input[name*="[title]"], [data-formengine-input-name*="[title]"]').first().fill(title);
    await ctx.locator('input[name*="[street]"], [data-formengine-input-name*="[street]"]').first().fill(street);
    await ctx.locator('input[name*="[zip]"], [data-formengine-input-name*="[zip]"]').first().fill(zip);
    await ctx.locator('input[name*="[city]"], [data-formengine-input-name*="[city]"]').first().fill(city);

    // Trigger geolocation - "Aktualisiere mit Adresse" button updates from address fields
    const geocodeButton = ctx.getByRole('button', { name: /Aktualisiere mit Adresse|Update from address/i }).first();
    if (await geocodeButton.isVisible().catch(() => false)) {
        await geocodeButton.click();
        await page.waitForTimeout(3000);
    }

    await selectCategoriesByTitle(ctx, page, categoryTitles);

    await saveRecord(page, ctx);

    let uid = await extractSavedUid(page, 'tx_gomapsext_domain_model_address');
    if (uid === null) {
        uid = await findRecordByTitle(page, 'tx_gomapsext_domain_model_address', title, pid);
    }
    return uid;
}

export async function createAddressWithCoordinates(
    page: Page,
    title: string,
    lat: string,
    lng: string,
    categoryTitles: string[] = [],
    pid: number = 1
): Promise<number | null> {
    const ctx = await createRecord(page, 'tx_gomapsext_domain_model_address', pid);

    await ctx.locator('input[name*="[title]"], [data-formengine-input-name*="[title]"]').first().fill(title);
    await ctx.locator('input[name*="[latitude]"], [data-formengine-input-name*="[latitude]"]').first().fill(lat);
    await ctx.locator('input[name*="[longitude]"], [data-formengine-input-name*="[longitude]"]').first().fill(lng);

    await selectCategoriesByTitle(ctx, page, categoryTitles);

    await saveRecord(page, ctx);

    let uid = await extractSavedUid(page, 'tx_gomapsext_domain_model_address');
    if (uid === null) {
        uid = await findRecordByTitle(page, 'tx_gomapsext_domain_model_address', title, pid);
    }
    return uid;
}

export async function createMapWithConfig(
    page: Page,
    title: string,
    config: {
        enableSearch?: boolean;
        enableCategories?: boolean;
        enableRoute?: boolean;
        styledMap?: boolean;
        addressUids?: number[];
    } = {},
    pid: number = 1
): Promise<number | null> {
    const ctx = await createRecord(page, 'tx_gomapsext_domain_model_map', pid);

    await ctx.locator('input[name*="[title]"], [data-formengine-input-name*="[title]"]').first().fill(title);

    if (config.enableSearch) {
        const tab = ctx.getByRole('tab', { name: /Steuerung|Control/i }).first();
        if (await tab.isVisible().catch(() => false)) {
            await tab.click();
            await page.waitForTimeout(500);
        }
        await ctx.locator('input[name*="[show_search]"][value="1"]').first().check().catch(() => {});
    }

    if (config.enableCategories) {
        const tab = ctx.getByRole('tab', { name: /Steuerung|Control/i }).first();
        if (await tab.isVisible().catch(() => false)) {
            await tab.click();
            await page.waitForTimeout(500);
        }
        await ctx.locator('input[name*="[show_categories]"][value="1"]').first().check().catch(() => {});
    }

    if (config.enableRoute) {
        const tab = ctx.getByRole('tab', { name: /Route/i }).first();
        if (await tab.isVisible().catch(() => false)) {
            await tab.click();
            await page.waitForTimeout(500);
        }
        await ctx.locator('input[name*="[calc_route]"][value="1"]').first().check().catch(() => {});
    }

    if (config.styledMap) {
        const tab = ctx.getByRole('tab', { name: /Style/i }).first();
        if (await tab.isVisible().catch(() => false)) {
            await tab.click();
            await page.waitForTimeout(500);
        }
        await ctx.locator('input[name*="[styled_map]"][value="1"]').first().check().catch(() => {});
    }

    await saveRecord(page, ctx);

    let uid = await extractSavedUid(page, 'tx_gomapsext_domain_model_map');
    if (uid === null) {
        uid = await findRecordByTitle(page, 'tx_gomapsext_domain_model_map', title, pid);
    }
    return uid;
}

export async function createContentElementWithMap(
    page: Page,
    mapUid: number,
    pid: number = 1
): Promise<void> {
    const ctx = await createRecord(page, 'tt_content', pid);

    await ctx.locator('select[name*="[CType]"], [data-formengine-input-name*="[CType]"]').first()
        .selectOption({ label: 'Zeige Karte' });
    await page.waitForTimeout(1500);

    // Select map in flexform
    const mapSelect = ctx.locator('select[name*="settings.map"], [name*="[pi_flexform]"][name*="map"]').first();
    if (await mapSelect.isVisible().catch(() => false)) {
        await mapSelect.selectOption(mapUid.toString()).catch(() => {});
    }

    await saveRecord(page, ctx);
}
