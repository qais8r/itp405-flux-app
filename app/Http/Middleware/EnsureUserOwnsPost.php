<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Post; // Import the Post model

class EnsureUserOwnsPost
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Get the post from the route model binding
        $post = $request->route('post');

        // Check if the post exists and if the authenticated user's ID matches the post's user_id
        if (!$post || $post->user_id !== auth()->id()) {
            // If not the owner, abort with a 403 Forbidden error
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
}
