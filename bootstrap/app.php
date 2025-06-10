<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        
        // Définit les alias pour les middlewares
        $middleware->alias([
            
            // Ce middleware se trouve maintenant dans le dossier du framework Illuminate, et non plus dans app/
            'auth' => \Illuminate\Auth\Middleware\Authenticate::class,
            'guest' => \Illuminate\Auth\Middleware\RedirectIfAuthenticated::class, // <-- Chemin corrigé
            'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,

            // Notre alias personnalisé, qui lui est bien dans app/
            'admin' => \App\Http\Middleware\AdminMiddleware::class, 
        ]);

    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();