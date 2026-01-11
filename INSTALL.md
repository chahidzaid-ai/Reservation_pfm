## Register middleware (important)

In `app/Http/Kernel.php`, add:

```php
protected $routeMiddleware = [
    // ...
    'role' => \App\Http\Middleware\RoleMiddleware::class,
    'active' => \App\Http\Middleware\EnsureUserIsActive::class,
];
```

(If you're on Laravel 11, register middleware in `bootstrap/app.php` instead.)
