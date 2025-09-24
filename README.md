<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Cambios realizados

### 1. Configuración de idioma

- Se instaló el paquete de localización `laravel-lang/common` mediante Composer.
- Se agregó el idioma español al sistema de traducciones de Laravel.
- Se estableció el idioma predeterminado (`locale`) en español (`es`) en el archivo `.env` y en `config/app.php`.
- Ahora todos los textos y mensajes del sistema aparecen en español.

**Cómo verificarlo:**  
Iniciar la aplicación y observar que los formularios y mensajes de error se muestran en español.

### 2. Configuración de zona horaria

- Se ajustó el parámetro `timezone` en el archivo `config/app.php` a `America/Merida` (o la zona correspondiente).
- Esto permitirá que los registros y fechas/timestamps se almacenen con la hora local de México Sureste.

**Cómo verificarlo:**  
Registrar un usuario o un evento y comprobar en la base de datos que la fecha/hora corresponde a la zona horaria configurada.

### 3. Integración de MySQL

- Se configuró la conexión a MySQL en el archivo `.env`:
  - `DB_CONNECTION=mysql`
  - `DB_HOST=127.0.0.1`
  - `DB_PORT=3306`
  - `DB_DATABASE=appointment_db_4b` (o el nombre de tu base de datos)
  - `DB_USERNAME=usuario` (el usuario configurado en MySQL)
  - `DB_PASSWORD=contraseña` (la contraseña correspondiente)
- Se realizó la migración de las tablas con `php artisan migrate`.

**Cómo verificarlo:**  
Acceder a tu gestor de base de datos (phpMyAdmin, DBeaver, etc.) y comprobar que existen las tablas de Laravel.

### 4. Carga de foto de perfil

- Se habilitó la funcionalidad de cargar foto de perfil para los usuarios (Jetstream).
- Se configuró el almacenamiento en el disco `public` mediante el parámetro `FILESYSTEM_DISK=public` en `.env`.
- Ahora puedes subir tu foto de perfil desde el panel de usuario.

**Cómo verificarlo:**  
Ingresar como usuario, ir a la sección de perfil y cargar una foto. Debe visualizarse tu imagen y almacenarse en `storage/app/public`.

---
# Actividad 4 - Panel administrativo con Flowbite

Este proyecto implementa un panel administrativo en Laravel utilizando Blade y la librería de componentes **Flowbite**.  
La actividad corresponde a la Unidad 1 y busca que el estudiante comprenda la importancia de los layouts y slots en la organización de vistas.

---

## Pasos realizados

### 1. Creación del nuevo layout
1. Generé el componente con Artisan:
   ```bash
   php artisan make:component AdminLayout
Moví el archivo generado a resources/views/layouts/admin.blade.php.

Configuré la ruta admin.dashboard en routes/web.php:

```php
Route::get('/admin', function () {
    return view('admin.dashboard');
})->name('admin.dashboard');
```
Creé la vista resources/views/admin/dashboard.blade.php con el siguiente contenido de prueba:

```blade
<x-admin-layout>
    Hola desde admin
</x-admin-layout>
```
### 2. Integración de Flowbite
Instalé Flowbite con npm:

```bash
npm install flowbite
```
Agregué la configuración en tailwind.config.js:

```js
module.exports = {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./node_modules/flowbite/**/*.js"
  ],
  theme: {
    extend: {},
  },
  plugins: [
    require('flowbite/plugin')
  ],
}
```
Ejecuté la compilación:

```bash
npm run build
```
Copié el ejemplo de Sidebar with Navbar desde la documentación de Flowbite y lo adapté en admin.blade.php.

### 3. Separación de código con includes
Creé dos archivos en resources/views/includes/:

navigation.blade.php → código del navbar.

sidebar.blade.php → código del sidebar.

En el layout (admin.blade.php), los integré con:

```blade

@include('includes.navigation')
@include('includes.sidebar')
```
### 4. Prueba de slots e información dinámica
En dashboard.blade.php probé el uso de {{$slot}} con el texto:

```blade
<x-admin-layout>
    Hola desde admin
</x-admin-layout>
```
Confirmé que el contenido se mostrara correctamente en el layout.
Incorporé la información de usuario en el navbar para el dropdown de perfil.
## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
