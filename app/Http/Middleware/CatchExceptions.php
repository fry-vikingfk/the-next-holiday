<?php

namespace App\Http\Middleware;

use Closure;
use Throwable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class CatchExceptions
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            return $next($request);
        } catch (ValidationException $e) {
            return response()->json([
                'error' => 'Validation failed',
                'messages' => $e->errors(),
            ], 422);
        } catch (HttpExceptionInterface $e) {
            return response()->json([
                'error' => $e->getMessage() ?: 'HTTP Exception',
            ], $e->getStatusCode());
        } catch (Throwable $e) {
            Log::error($e); // Log the full error

            return response()->json([
                'error' => 'Internal server error.',
                'message' => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        }
    }
}
