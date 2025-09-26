<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    public function login()
    {
        if (session()->get('logged_in')) {
            return redirect()->to('/dashboard');
        }

        if ($this->request->getMethod() === 'POST') {
            $userModel = new UserModel();
            $email = $this->request->getPost('email');
            $password = $this->request->getPost('password');

            $user = $userModel->where('email', $email)->first();

            if (!$user) {
                return redirect()->back()->with('error', '❌ Email not found in database');
            }

            if (!password_verify($password, $user['password'])) {
                return redirect()->back()->with('error', '❌ Wrong password. Try: Admin123! / Teacher123! / Student123!');
            }

            // ✅ Login success
            session()->set([
                'user_id'   => $user['id'],
                'username'  => $user['username'],
                'role'      => $user['role'],
                'logged_in' => true
            ]);

            return redirect()->to('/dashboard');
        }

        return view('auth/login');
    }

    public function register()
{
    if ($this->request->getMethod() === 'GET') {
        return view('auth/register');
    }

    if ($this->request->getMethod() === 'POST') {
        $userModel = new UserModel();

        $data = [
            'username' => trim($this->request->getPost('username')),
            'email'    => trim($this->request->getPost('email')),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role'     => 'student' // default role
        ];

        if ($userModel->save($data)) {
            // Instead of auto login → redirect to login page
            return redirect()->to('/login')
                             ->with('success', 'Registration successful. Please login.');
        } else {
            return redirect()->back()
                             ->with('error', 'Registration failed. ' . implode(', ', $userModel->errors()));
        }
    }
}


    public function dashboard()
    {
        if (! session()->get('logged_in')) {
            return redirect()->to('/login')->with('error', 'Please login first.');
        }

        $data = [
            'role' => session()->get('role'),
            'name' => session()->get('username'),
        ];

        // ✅ Pointing to unified dashboard view inside /auth
        return view('auth/dashboard', $data);
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login')->with('success', 'Logged out successfully.');
    }
}
