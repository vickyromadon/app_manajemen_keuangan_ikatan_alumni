<?php

namespace App\Http\Middleware;

use Closure;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $permission = $request->path();

        if ($permission !== "admin") {
            $temp = explode("/", $permission);
            $permission = $temp[1];
        }

        if (!$request->user()->can($permission) && !($permission == "admin" || $permission == "/admin")) {
            if ($request->ajax()) {
                return response()->json(
                    [
                        'data' => '',
                        'message' => 'Permintaan tidak diperbolehkan. Silahkan periksa jabatan anda.',
                        'status' => false
                    ]
                );
            }
            abort(404, "Halaman Tidak di Temukan!");
        }

        return $next($request);
    }
}
