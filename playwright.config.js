import { defineConfig, devices } from '@playwright/test';

export default defineConfig({
    testDir: './tests/e2e',

    timeout: 60000,

    use: {
        baseURL: 'http://localhost:8000',
        browserName: 'chromium',
        headless: true,
        screenshot: 'only-on-failure',
        video: 'retain-on-failure',
    },

    projects: [
        {
            name: 'chromium',
            use: {
                ...devices['Desktop Chrome'],
            },
        },
    ],
});