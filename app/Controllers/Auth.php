<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    protected $helpers = ['form', 'url'];

    // ✅ LOGIN
    public function login()
    {
        // If already logged in, go to dashboard
        if (session()->get('logged_in')) {
            return redirect()->to('/dashboard');
        }

        // If GET request — just show login form
        if ($this->request->getMethod() === 'GET') {
            return view('auth/login');
        }

        // If POST request — process login
        if ($this->request->getMethod() === 'POST') {
            // Validation rules
            if (!$this->validate([
                'email'    => 'required|valid_email',
                'password' => 'required|min_length[6]',
            ])) {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }

            $userModel = new UserModel();
            $email     = $this->request->getPost('email');
            $password  = $this->request->getPost('password');

            $user = $userModel->where('email', $email)->first();

            if (!$user) {
                return redirect()->back()->withInput()->with('error', '❌ Email not found.');
            }

            if (!password_verify($password, $user['password'])) {
                return redirect()->back()->withInput()->with('error', '❌ Incorrect password.');
            }

            // ✅ Login success
            session()->set([
                'user_id'   => $user['id'],
                'username'  => $user['username'],
                'email'     => $user['email'],
                'role'      => $user['role'],
                'logged_in' => true
            ]);

            return redirect()->to('/dashboard')->with('success', 'Welcome back, ' . $user['username'] . '!');
        }
    }

    // ✅ REGISTER
    public function register()
    {
        // If already logged in, redirect to dashboard
        if (session()->get('logged_in')) {
            return redirect()->to('/dashboard');
        }

        // If GET — show register page
        if ($this->request->getMethod() === 'GET') {
            return view('auth/register');
        }

        // If POST — process registration
        if ($this->request->getMethod() === 'POST') {
            // Validate input
            if (!$this->validate([
                'username'         => 'required|min_length[3]',
                'email'            => 'required|valid_email|is_unique[users.email]',
                'password'         => 'required|min_length[6]',
                'confirm_password' => 'required|matches[password]',
            ])) {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }

            $userModel = new UserModel();

            $data = [
                'username' => $this->request->getPost('username'),
                'email'    => $this->request->getPost('email'),
                'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
                'role'     => 'student'
            ];

            // Save user
            if ($userModel->save($data)) {
                // ✅ After successful registration — auto login
                session()->set([
                    'user_id'   => $userModel->getInsertID(),
                    'username'  => $data['username'],
                    'email'     => $data['email'],
                    'role'      => $data['role'],
                    'logged_in' => true,
                ]);

                return redirect()->to('/dashboard')->with('success', 'Account created successfully. Welcome, ' . $data['username'] . '!');
            } else {
                return redirect()->back()->with('error', 'Registration failed. Please try again.');
            }
        }
    }

    // ✅ DASHBOARD
    public function dashboard()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login')->with('error', 'Please login first.');
        }

        $data = [
            'username' => session()->get('username'),
            'role'     => session()->get('role'),
        ];

        return view('auth/dashboard', $data);
    }

    // ✅ LOGOUT
    public function logout()    
    {
        session()->destroy();
        return redirect()->to('/login')->with('success', 'You have been logged out successfully.');
    }
}
