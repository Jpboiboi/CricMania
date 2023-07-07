<?php

namespace App\Http\Middleware;

use App\Models\Tournament;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ValidateOrganizer
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $tournament = $request->tournament;

        if(!auth()->user()->isAdmin() && !auth()->user()->isOwner($tournament)) {
            return abort(403);
        }

        return $next($request);
    }
}
