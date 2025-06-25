<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController as FortifyController;
use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Contracts\LogoutResponse;
use Laravel\Fortify\Contracts\LoginResponse;


class AuthenticatedSessionController extends FortifyController
{
    // オーバーライドしてログイン後の遷移先を変更
    public function store(Request $request): LoginResponse
    {
        $this->validateLogin($request);

        if (method_exists($this, 'attemptLogin') && $this->attemptLogin($request)) {
            $request->session()->regenerate();

            return app(LoginResponse::class);
        }

        return $this->sendFailedLoginResponse($request);
    }

    // オーバーライドしてログアウト後の遷移先を変更
    public function destroy(Request $request): LogoutResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // LogoutResponseインスタンスを返す（ここでリダイレクトが制御される）
        return app(LogoutResponse::class);
    }
}