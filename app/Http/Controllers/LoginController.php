<?php

namespace App\Http\Controllers;

use Psr\Http\Message\ServerRequestInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LoginController extends Controller
{
    function authenticate(ServerRequestInterface $request): RedirectResponse
    {
        $data = $request->getParsedBody();
        $credentials = [
            'email' => $data['email'],
            'password' => $data['password'],
        ];
        // authenticate by using method attempt()
        if (Auth::attempt($credentials)) {
            // regenerate the new session ID
            session()->regenerate();

            // redirect to the requested URL or
            // to route products.list if does not specify
            return redirect()->intended(route('products.list'));
            // return redirect()->back()->withErrors([
            //     'credentials' => 'The provided credentials do not match our records.',
            //     ]);
        }
        else{
            return redirect()->back()->withErrors([
                'credentials' => 'The provided credentials do not match our records.',
            ]);
        }
    }

    function showLoginForm(): View
    {
        return view('login.form');
    }
    function logout(): RedirectResponse
    {
        Auth::logout();
        session()->invalidate();
        //regenerate CSRF TOKEN
        session()->regenerateToken();
        return redirect()->route('login');
    }
}
