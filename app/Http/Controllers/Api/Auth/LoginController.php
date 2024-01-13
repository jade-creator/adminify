<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\LoginRequest;
use App\Models\Admin;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Spatie\RouteAttributes\Attributes\Post;
use Spatie\RouteAttributes\Attributes\Prefix;

/**
 * @tags Admin
 */
#[Prefix('admins')]
class LoginController extends Controller
{
    /** @throws \Illuminate\Auth\AuthenticationException */
    #[Post(uri: 'login', name: 'admins.login')]
    public function __invoke(LoginRequest $request): Response
    {
        /** @var string */
        $identifier = $request->input('identifier');
        $field = filter_var($identifier, FILTER_VALIDATE_EMAIL)
            ? 'email'
            : 'username';

        $credentials = [
            $field => $identifier,
            'password' => $request->input('password')
        ];

        if (! Auth::guard('admin')->attempt($credentials)) {
            throw new AuthenticationException(trans('Invalid credentials!'));
        }

        $admin = Admin::whereEmail($identifier)
            ->orWhere('username', $identifier)
            ->first();

        if (is_null($admin)) {
            throw new AuthenticationException(trans('Invalid Credentials!'));
        }

        return response([
            'admin' => $admin,
            'token' => $admin->createToken('admin')->plainTextToken
        ]);
    }
}
