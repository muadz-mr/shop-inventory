## Repo README.md Content

-   Filament has a few requirements to run:
    -   PHP 8.0+
    -   Laravel v8.0+
    -   Livewire v2.0+
-   Create [new Laravel](<[https://laravel.com/docs/9.x/installation](https://laravel.com/docs/9.x/installation)>) project
-   Install Laravel Breeze with Blade:
    1. Install Breeze package

        ```powershell
        composer require laravel/breeze --dev
        ```

    2. Publish the authentication views, routes, controllers, and other resources to your application

        ```powershell
        php artisan breeze:install
        ```
-   Migrate the migration after installing breeze package and publishing necessary resources
    ```powershell
    php artisan migrate && npm install
    ```
-   Install Filament PHP admin package
    ```powershell
    composer require filament/filament
    ```
-   You may create a new user account using command below
    ```powershell
    php artisan make:filament-user
    ```
-   Visit your admin panel at `/admin` to sign in and start developing
