<?php

namespace Azuriom\Plugin\Forum\Middleware;

use Azuriom\Plugin\Forum\Models\ForumUser;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UpdateLastActivity
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        return $next($request);
    }

    /**
     * Handle tasks after the response has been sent to the browser.
     */
    public function terminate(Request $request): void
    {
        if (($user = $request->user()) !== null) {
            ForumUser::updateOrCreate(['user_id' => $user->id], [
                'last_seen_at' => now(),
            ]);
        }
    }
}
