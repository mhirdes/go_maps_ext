import { test as setup } from '@playwright/test';
import { login, AUTH_STATE_PATH } from './Helpers/Backend';
import * as fs from 'fs';
import * as path from 'path';

setup('authenticate', async ({ page }) => {
    const authDir = path.dirname(AUTH_STATE_PATH);
    if (!fs.existsSync(authDir)) {
        fs.mkdirSync(authDir, { recursive: true });
    }
    await login(page);
    await page.context().storageState({ path: AUTH_STATE_PATH });
});
