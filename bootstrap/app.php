<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

// Import your middleware classes
use App\Http\Middleware\EnsureUserOwnsPost;
use App\Http\Middleware\EnsureUserOwnsComment;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Register route middleware aliases
        $middleware->alias([
            'owns.post' => EnsureUserOwnsPost::class,
            'owns.comment' => EnsureUserOwnsComment::class,
            // Add other aliases here if needed
        ]);

        // You can also add middleware globally or to groups here
        // $middleware->web(append: [ ... ]);
        // $middleware->api(prepend: [ ... ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
