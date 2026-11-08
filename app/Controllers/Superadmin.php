<?php

namespace App\Controllers;

class Superadmin extends BaseController
{
    public function index()
    {
        return view('superadmin/dashboard', [
            'title' => 'Dashboard Superadmin',
        ]);
    }
}
