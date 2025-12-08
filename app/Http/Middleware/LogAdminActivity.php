<?php

namespace App\Http\Middleware;

use App\Models\ActivityLog;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LogAdminActivity
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        $user = $request->user();

        if ($user && $user->role === 'admin') {
            $routeName = $request->route()?->getName() ?? $request->path();

            ActivityLog::create([
                'user_id' => $user->id,
                'action' => $routeName,
                'description' => 'Visited ' . $routeName,
                'ip_address' => $request->ip(),
                'user_agent' => substr((string) $request->userAgent(), 0, 255),
                'url' => substr($request->fullUrl(), 0, 255),
            ]);
        }

        return $response;
    }
}
