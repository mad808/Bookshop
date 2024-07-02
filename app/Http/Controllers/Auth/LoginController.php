<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function create()
    {
        return view('auth.login');
    }


    public function store(LoginRequest $request): RedirectResponse
    {
        try {
            $request->authenticate();
        } catch (ValidationException $e) {
        }

        $request->session()->regenerate();
        if (Auth::User()->admin == 1) {
            return redirect()->intended(RouteServiceProvider::ADMIN)->with(['success' => trans('app.welcome') . ' ' . auth()->user()->name]);
        } else {
            return redirect()->intended(RouteServiceProvider::HOME)->with([
                'success' => trans('app.welcome') . ' ' . auth()->user()->name
            ]);
        }
    }


    public function destroy(Request $request): \Illuminate\Http\RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->intended(RouteServiceProvider::HOME)->with([
            'success' => trans('app.logouted')
        ]);
    }
}
