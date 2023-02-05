<?php

namespace Azuriom\Plugin\Forum\Middleware;

use Azuriom\Plugin\Forum\Models\ForumUser;
use Closure;
use Illuminate\Http\Request;

class UpdateLastActivity
{
    public function handle(Request $request, Closure $next)
    {
        return $next($request);
    }

    public function terminate(Request $request)
    {
        $user = $request->user();

        if ($user !== null) {
            ForumUser::updateOrCreate(['user_id' => $user->id], [
                'last_seen_at' => now(),
            ]);
        }
    }
}
