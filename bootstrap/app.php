<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Auth\AuthenticationException; // <-- 1. ADICIONE ESTE IMPORT

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Seus outros middlewares...
    })
    ->withExceptions(function (Exceptions $exceptions) {
        
        // 2. AQUI ESTÁ A CORREÇÃO
        // Em vez de ->unauthenticated(), nós interceptamos a exceção
        // específica de autenticação.
        $exceptions->render(function (AuthenticationException $e, Request $request) {
            
            // Verificamos se a requisição é para a área de admin
            if ($request->is('admin') || $request->is('admin/*')) {
                // Se for, redireciona para a rota de login do admin
                return redirect()->route('login_admin');
            }

            // 3. Caso contrário, use o redirecionamento padrão (para usuários normais)
            // (Lembre-se da minha nota anterior sobre a necessidade de uma rota GET 'login')
            return redirect()->guest(route('login'));
        });

    })->create();