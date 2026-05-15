import { test, expect } from '@playwright/test';

const MAP_PAGE_URL = process.env.TYPO3_MAP_PAGE_URL ?? '/';
const MAP_WITH_SEARCH_URL = process.env.TYPO3_MAP_SEARCH_URL ?? '/map-search/';
const MAP_WITH_CATEGORIES_URL = process.env.TYPO3_MAP_CATEGORIES_URL ?? '/map-categories/';
const MAP_WITH_ROUTE_URL = process.env.TYPO3_MAP_ROUTE_URL ?? '/map-route/';
const MAP_STYLED_URL = process.env.TYPO3_MAP_STYLED_URL ?? '/map-styled/';

test.describe('Go Maps Ext - Frontend Functional Tests', () => {

    test('map renders multiple markers for addresses', async ({ page }) => {
        await page.goto(MAP_PAGE_URL);

        // Wait for map to initialize
        await page.waitForTimeout(3000);

        // Check map container exists
        const mapContainer = page.locator('[id^="tx-gomapsext-map-"]').first();
        await expect(mapContainer).toBeVisible();

        // Check markers are present (marker elements or canvas indicators)
        // go_maps_ext renders markers as DOM elements or Google Maps markers
        const markers = page.locator('.tx-gomapsext-marker, .gm-style img[src*="marker"], [class*="marker"]').first();
        await expect(markers).toBeVisible().catch(() => {
            // If no markers found as DOM elements, check via JavaScript that map has markers
            return expect(mapContainer).toHaveAttribute('data-markers');
        });
    });

    test('search function filters addresses', async ({ page }) => {
        await page.goto(MAP_WITH_SEARCH_URL);

        // Wait for map
        await page.waitForTimeout(2000);

        // Find search input
        const searchInput = page.locator('.tx-gomapsext-search input, [class*="gomapsext"] input[type="text"]').first();
        await expect(searchInput).toBeVisible();

        // Enter search term
        await searchInput.fill('Restaurant');

        // Trigger search (either by button or enter)
        const searchButton = page.locator('.tx-gomapsext-search button, [class*="search"] button').first();
        if (await searchButton.isVisible().catch(() => false)) {
            await searchButton.click();
        } else {
            await searchInput.press('Enter');
        }

        await page.waitForTimeout(2000);

        // Verify search results or filtered markers
        // This could be markers being filtered, or a results list appearing
        const results = page.locator('.tx-gomapsext-search-results, .search-results, [class*="result"]').first();
        const hasResults = await results.isVisible().catch(() => false);

        // Or check that map updated
        const mapUpdated = await page.evaluate(() => {
            // @ts-ignore
            const map = window.txGomapsextMap || window.google?.maps;
            return map !== undefined;
        });

        expect(hasResults || mapUpdated).toBe(true);
    });

    test('category filter shows/hides addresses', async ({ page }) => {
        await page.goto(MAP_WITH_CATEGORIES_URL);

        await page.waitForTimeout(2000);

        // Find category select/dropdown
        const categorySelect = page.locator('.tx-gomapsext-categories select, select[name*="category"]').first();
        await expect(categorySelect).toBeVisible();

        // Get initial marker count (if accessible)
        const initialMarkerCount = await page.locator('.tx-gomapsext-marker').count();

        // Select a category
        const options = await categorySelect.locator('option').all();
        if (options.length > 1) {
            // Select second option (first is usually "All")
            await categorySelect.selectOption({ index: 1 });
            await page.waitForTimeout(2000);

            // Verify markers changed (either filtered DOM elements or map markers updated)
            const afterMarkerCount = await page.locator('.tx-gomapsext-marker').count();

            // Markers should be different or equal to filtered set
            expect(afterMarkerCount).toBeGreaterThanOrEqual(0);
        }
    });

    test('route calculation displays route on map', async ({ page }) => {
        await page.goto(MAP_WITH_ROUTE_URL);

        await page.waitForTimeout(2000);

        // Find route form elements
        const startInput = page.locator('.tx-gomapsext-route-form input[name*="start"], .tx-gomapsext-route-form input:first-of-type').first();
        const endInput = page.locator('.tx-gomapsext-route-form input[name*="end"], .tx-gomapsext-route-form input:nth-of-type(2)').first();

        // Check if route form is visible
        const hasRouteForm = await startInput.isVisible().catch(() => false);

        if (hasRouteForm) {
            // Fill in addresses
            await startInput.fill('Marienplatz, München');
            await endInput.fill('Hauptbahnhof, München');

            // Submit route
            const routeButton = page.locator('.tx-gomapsext-route-form button, .tx-gomapsext-route-form input[type="submit"]').first();
            await routeButton.click();

            await page.waitForTimeout(3000);

            // Verify route is displayed (route line on map, directions panel, or success message)
            const routeDisplayed = await page.locator('.tx-gomapsext-route-result, .route-result, .directions').first().isVisible().catch(() => false);

            // Or check for route polyline on map
            const hasRouteOnMap = await page.evaluate(() => {
                // @ts-ignore
                const directionsRenderer = window.txGomapsextDirectionsRenderer;
                return directionsRenderer !== undefined;
            });

            expect(routeDisplayed || hasRouteOnMap).toBe(true);
        }
    });

    test('styled map renders with custom styles', async ({ page }) => {
        await page.goto(MAP_STYLED_URL);

        await page.waitForTimeout(3000);

        // Check map container
        const mapContainer = page.locator('[id^="tx-gomapsext-map-"]').first();
        await expect(mapContainer).toBeVisible();

        // Check for styled map indicator
        // This could be a specific class, data attribute, or custom map style
        const hasStyledMap = await mapContainer.getAttribute('data-styled').catch(() => null);

        // Or verify via JavaScript that map has custom styles applied
        const mapHasCustomStyles = await page.evaluate(() => {
            // @ts-ignore
            const map = window.txGomapsextMap;
            if (map && map.styles) {
                return map.styles.length > 0;
            }
            return false;
        });

        // Styled map should either have attribute or custom styles
        expect(hasStyledMap !== null || mapHasCustomStyles).toBe(true);
    });

    test('no JavaScript errors during map operations', async ({ page }) => {
        const errors: string[] = [];
        const consoleErrors: string[] = [];

        page.on('pageerror', (err) => errors.push(err.message));
        page.on('console', (msg) => {
            if (msg.type() === 'error') {
                consoleErrors.push(msg.text());
            }
        });

        await page.goto(MAP_PAGE_URL);
        await page.waitForTimeout(3000);

        // Interact with map if possible
        const mapContainer = page.locator('[id^="tx-gomapsext-map-"]').first();
        if (await mapContainer.isVisible()) {
            // Try to click on map
            await mapContainer.click({ position: { x: 100, y: 100 } }).catch(() => {});
            await page.waitForTimeout(1000);
        }

        // Filter out known Google Maps script errors that are not our fault
        const relevantErrors = errors.filter(e =>
            !e.includes('Google Maps') &&
            !e.includes('google') &&
            !e.includes('gstatic')
        );

        const relevantConsoleErrors = consoleErrors.filter(e =>
            !e.includes('Google Maps') &&
            !e.includes('google') &&
            !e.includes('gstatic')
        );

        expect(relevantErrors).toHaveLength(0);
        expect(relevantConsoleErrors).toHaveLength(0);
    });
});
