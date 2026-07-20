import { test, expect } from '@playwright/test';

test('usuario autenticado puede abrir el formulario de registro de mascota', async ({ page }) => {

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

    // 5. Esperar un momento para que Laravel/Inertia actualice la sesión
    await page.waitForTimeout(2000);

    // 6. Verificar que existe la cookie de sesión
    const cookies = await page.context().cookies();

    const sessionCookie = cookies.find(
        cookie => cookie.name === 'laravel_session'
    );

    expect(sessionCookie).toBeDefined();

    // 7. Acceder al módulo de mascotas
    await page.goto('/pets');

    await expect(page).toHaveURL(/\/pets/);

    // 8. Ir al formulario de creación
    await page.goto('/pets/create');

    // 9. Verificar que la URL es correcta
    await expect(page).toHaveURL(/\/pets\/create/);

    // 10. Verificar que el formulario está visible
    await expect(page.locator('#name')).toBeVisible();
});