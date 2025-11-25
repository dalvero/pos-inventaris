<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    // Middleware global
    protected $middleware = [
        // Bisa kosong dulu
    ];

    // Middleware route (penting!)
    protected $routeMiddleware = [
        // middleware default Laravel
        'auth' => \App\Http\Middleware\Authenticate::class,
        // middleware custom role
        'role' => \App\Http\Middleware\RoleMiddleware::class, 
    ];

}
