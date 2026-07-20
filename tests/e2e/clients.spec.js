import { test, expect } from '@playwright/test';

test('usuario autenticado puede acceder al módulo de clientes', async ({ page }) => {

    // 1. Ir al login
    await page.goto('/login');

    // 2. Completar credenciales
    await page.locator('#email').fill('e2e@petcare.test');
    await page.locator('#password').fill('password');

    // 3. Iniciar sesión
    await page.locator('#login-button').click();

    // 4. Esperar la respuesta del login
    await page.waitForResponse(response =>
        response.url().includes('/login') &&
        response.request().method() === 'POST'
    );

    // 5. Esperar a que Laravel/Inertia actualice la sesión
    await page.waitForTimeout(2000);

    // 6. Verificar que existe la sesión
    const cookies = await page.context().cookies();

    const sessionCookie = cookies.find(
        cookie => cookie.name === 'laravel_session'
    );

    expect(sessionCookie).toBeDefined();

    // 7. Acceder al módulo de clientes
    await page.goto('/clients');

    // 8. Verificar que la URL es correcta
    await expect(page).toHaveURL(/\/clients/);

    // 9. Verificar que la página se cargó
    await expect(page.locator('body')).toBeVisible();
});