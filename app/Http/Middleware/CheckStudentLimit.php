<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckStudentLimit
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        $planLimit = $user->plan->limit;
        $currentStudentCount = $user->students()->count();

        if ($currentStudentCount > $planLimit) {
            return response()->json(['error' => 'Limite de cadastro de estudantes atingido.'], 403);
        }

        return $next($request);
    }
}

