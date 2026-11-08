
<?php

namespace App\Controllers\Auth;

class LoginController extends \CodeIgniter\Shield\Controllers\LoginController
{
    public function loginView()
    {
        if (auth()->loggedIn()) {
            return redirect()
                ->to(config('Auth')->loginRedirect())
                ->withCookies();
        }

        return view('auth/login');
    }
}
