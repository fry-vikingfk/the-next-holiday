<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Throwable;

class CatchExceptions
{
    public function handle(Request $request, Closure $next): Response
    {
        try {
            return $next($request);

        } catch (ValidationException $e) {
            return response()->json([
                'error' => 'Validation failed',
                'messages' => $e->errors(),
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);

        } catch (HttpExceptionInterface $e) {
            return response()->json([
                'error' => $e->getMessage() ?: 'HTTP Exception',
            ], $e->getStatusCode());

        } catch (Throwable $e) {
            // Log the full error for debugging
            logger()->error('Unhandled exception in API', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'error' => 'Internal server error.',
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
