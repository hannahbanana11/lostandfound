<?php

namespace App\Controllers;

class Dashboard extends BaseController
{
    public function index()
    {
        $session = session();
        $user = $session->get('user');

        if (!$user) {
            return redirect()->to('/auth');
        }

        if ($user['role'] === 'admin') {
            return view('dashboard/admin', ['user' => $user]);
        } else {
            return view('dashboard/user', ['user' => $user]);
        }
    }
}
