<?php

namespace App\Controllers;

class DebugTest extends BaseController
{
    public function testAdminDashboard()
    {
        // Simulate an admin user session for testing
        $user = [
            'id' => 1,
            'name' => 'Test Admin',
            'email' => 'admin@test.com',
            'role' => 'admin'
        ];
        
        return view('dashboard/admin', ['user' => $user]);
    }
    
    public function testUserDashboard()
    {
        // Simulate a regular user session for testing
        $user = [
            'id' => 2,
            'name' => 'Test User',
            'email' => 'user@test.com',
            'role' => 'user'
        ];
        
        return view('dashboard/user', ['user' => $user]);
    }
}