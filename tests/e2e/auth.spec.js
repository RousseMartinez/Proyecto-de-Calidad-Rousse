import { test, expect } from '@playwright/test';

test('usuario puede iniciar sesión correctamente', async ({ page }) => {

    await page.goto('/login');

    await page.locator('#email').fill('e2e@petcare.test');
    await page.locator('#password').fill('password');

    await page.locator('#login-button').click();

    await page.waitForResponse(response =>
        response.url().includes('/login') &&
        response.request().method() === 'POST'
    );

    await page.waitForTimeout(2000);

    const cookies = await page.context().cookies();

    const sessionCookie = cookies.find(
        cookie => cookie.name === 'laravel_session'
    );

    expect(sessionCookie).toBeDefined();

    // Intentar acceder a una ruta protegida
    await page.goto('/pets');

    await expect(page).toHaveURL(/\/pets/);

    await expect(page.locator('body')).toBeVisible();
});