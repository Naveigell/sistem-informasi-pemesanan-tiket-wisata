<?php

namespace App\Http\Middleware;

use App\Enums\UserRoleEnum;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MustHaveRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $user = auth()->user();

        // if not logged in
        if (!$user) {
            return redirect(route('home.index'));
        }

        foreach (UserRoleEnum::cases() as $case) {

            // check if case is in roles
            if (in_array($case->value, $roles)) {

                // check if user has the same role as we put it in middleware parameter
                if ($user->isRole($case->model())) {
                    return $next($request);
                }
            }
        }

        return redirect(route('home.index'));
    }
}
