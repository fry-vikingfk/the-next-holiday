<?php

namespace App\Http\Middleware;

use Closure;
use Throwable;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

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
            return response()->json([
                'error' => 'Internal server error.',
                'message' => config('app.debug') ? $e->getMessage() : null,
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}

