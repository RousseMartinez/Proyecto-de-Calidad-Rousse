import { test, expect } from '@playwright/test';

test('usuario autenticado puede acceder al módulo de mascotas', async ({ page }) => {

    // 1. Abrir la página de login
    await page.goto('/login');

    // 2. Ingresar credenciales
    await page.locator('#email').fill('e2e@petcare.test');
    await page.locator('#password').fill('password');

    // 3. Iniciar sesión
    await page.locator('#login-button').click();

    // 4. Esperar la respuesta del login
    await page.waitForResponse(response =>
        response.url().includes('/login') &&
        response.request().method() === 'POST'
    );

    // 5. Esperar un momento para que la sesión se establezca
    await page.waitForTimeout(2000);

    // 6. Acceder al módulo de mascotas
    await page.goto('/pets');

    // 7. Verificar que la URL corresponde al módulo
    await expect(page).toHaveURL(/\/pets/);

    // 8. Verificar que la página está visible
    await expect(page.locator('body')).toBeVisible();
});