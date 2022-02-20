<?php

namespace Azuriom\Plugin\Forum\Middleware;

use Azuriom\Plugin\Forum\Models\ForumUser;
use Closure;
use Illuminate\Http\Request;

class UpdateLastActivity
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        if ($user !== null) {
            ForumUser::updateOrCreate(['user_id' => $user->id], ['last_seen_at' => now()]);
        }

        return $next($request);
    }
}
