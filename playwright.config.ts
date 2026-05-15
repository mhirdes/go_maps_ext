import { defineConfig, devices } from '@playwright/test';
import { config } from 'dotenv';
import { resolve } from 'path';

config({ path: resolve(__dirname, '.env') });

export default defineConfig({
    testDir: './Tests/Acceptance',
    fullyParallel: false,
    forbidOnly: !!process.env.CI,
    retries: process.env.CI ? 1 : 0,
    workers: 1,
    reporter: [
        ['list'],
        ['json', {  outputFile: 'test-results.json' }],
        ['html', { outputFolder: 'playwright-report', open: 'never' }],
    ],
    use: {
        baseURL: process.env.TYPO3_BASE_URL ?? 'https://typodummy-14.ddev.site',
        ignoreHTTPSErrors: true,
        screenshot: 'only-on-failure',
        video: 'retain-on-failure',
        trace: 'retain-on-failure',
    },
    projects: [
        {
            name: 'setup',
            testMatch: /auth\.setup\.ts/,
        },
        {
            name: 'backend',
            testDir: './Tests/Acceptance/Backend',
            use: {
                ...devices['Desktop Chrome'],
                storageState: '.auth/storageState.json',
            },
            dependencies: ['setup'],
        },
        {
            name: 'frontend',
            testDir: './Tests/Acceptance/Frontend',
            use: { ...devices['Desktop Chrome'] },
            dependencies: ['setup'],
        },
    ],
});
