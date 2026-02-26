<?php

namespace App\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * Admin panelinde 403 hatalarını admin layout içinde göster.
     */
    public function render($request, Throwable $e)
    {
        // 403 hatalarını admin layout içinde göster (sadece admin route'larında)
        if ($this->isAdminForbidden($request, $e)) {
            $message = $e->getMessage() ?: 'Bu sayfaya erişim yetkiniz yok.';

            return response()->view('admin.errors.403', [
                'errorMessage' => $message,
            ], 403);
        }

        return parent::render($request, $e);
    }

    /**
     * Yetkisiz erişim admin panel route'unda mı gerçekleşti?
     */
    private function isAdminForbidden($request, Throwable $e): bool
    {
        if (!str_starts_with($request->path(), 'admin/')) {
            return false;
        }

        if (!auth()->check()) {
            return false;
        }

        if ($request->expectsJson()) {
            return false;
        }

        return ($e instanceof HttpException && $e->getStatusCode() === 403)
            || ($e instanceof AuthorizationException);
    }
}
