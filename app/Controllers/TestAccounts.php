<?php

namespace App\Controllers;

use App\Models\UserModel;

class TestAccounts extends BaseController
{
    public function index()
    {
        return view('test_accounts/index');
    }

    public function createTestAccounts()
    {
        $userModel = new UserModel();
        
        // Check if test accounts already exist
        $adminExists = $userModel->where('email', 'admin@test.com')->first();
        $userExists = $userModel->where('email', 'user@test.com')->first();
        
        $messages = [];
        
        // Create admin test account
        if (!$adminExists) {
            $adminData = [
                'username' => 'testadmin',
                'email' => 'admin@test.com',
                'password' => password_hash('admin123', PASSWORD_DEFAULT),
                'role' => 'admin',
                'created_at' => date('Y-m-d H:i:s')
            ];
            
            if ($userModel->save($adminData)) {
                $messages[] = '✅ Admin test account created successfully!';
            } else {
                $messages[] = '❌ Failed to create admin test account.';
            }
        } else {
            $messages[] = '⚠️ Admin test account already exists.';
        }
        
        // Create user test account
        if (!$userExists) {
            $userData = [
                'username' => 'testuser',
                'email' => 'user@test.com',
                'password' => password_hash('user123', PASSWORD_DEFAULT),
                'role' => 'user',
                'created_at' => date('Y-m-d H:i:s')
            ];
            
            if ($userModel->save($userData)) {
                $messages[] = '✅ User test account created successfully!';
            } else {
                $messages[] = '❌ Failed to create user test account.';
            }
        } else {
            $messages[] = '⚠️ User test account already exists.';
        }
        
        return view('test_accounts/index', ['messages' => $messages]);
    }

    public function loginAsAdmin()
    {
        // Set session for admin test account
        $adminData = [
            'id' => 999,
            'username' => 'testadmin',
            'name' => 'Test Admin',
            'email' => 'admin@test.com',
            'role' => 'admin'
        ];
        
        session()->set('user', $adminData);
        return redirect()->to('/dashboard')->with('success', 'Logged in as Test Admin!');
    }

    public function loginAsUser()
    {
        // Set session for user test account
        $userData = [
            'id' => 998,
            'username' => 'testuser',
            'name' => 'Test User',
            'email' => 'user@test.com',
            'role' => 'user'
        ];
        
        session()->set('user', $userData);
        return redirect()->to('/dashboard')->with('success', 'Logged in as Test User!');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/test-accounts')->with('success', 'Logged out successfully!');
    }
}