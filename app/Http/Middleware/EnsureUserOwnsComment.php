<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Comment; // Import the Comment model

class EnsureUserOwnsComment
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Get the comment from the route model binding
        $comment = $request->route('comment');

        // Check if the comment exists and if the authenticated user's ID matches the comment's user_id
        if (!$comment || $comment->user_id !== auth()->id()) {
            // If not the owner, abort with a 403 Forbidden error
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
}
