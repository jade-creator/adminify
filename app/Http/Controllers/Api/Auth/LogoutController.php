<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Spatie\RouteAttributes\Attributes\Delete;
use Spatie\RouteAttributes\Attributes\Prefix;

/**
 * @tags Admin
 */
#[Prefix('admins')]
class LogoutController extends Controller
{
    /** @throws \Illuminate\Auth\AuthenticationException */
    #[Delete(uri: 'logout', name: 'admins.logout', middleware: 'auth:sanctum')]
    public function __invoke(Request $request): mixed
    {
        auth()->guard('admin')->logout();

        auth()->user()->tokens()->delete();

        return response([
            'message' => trans('User logged out.')
        ]);
    }
}
