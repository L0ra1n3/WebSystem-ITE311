<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    // Login
    public function login()
    {
        // If user is already logged in, go straight to dashboard
        if (session()->get('logged_in')) {
            return redirect()->to('dashboard');
        }

        // Process login on POST
        if ($this->request->getMethod() === 'POST') {
            $userModel = new UserModel();
            $email = $this->request->getPost('email');
            $password = $this->request->getPost('password');

            $user = $userModel->where('email', $email)->first();

            if ($user && password_verify($password, $user['password'])) {
                session()->set([
                    'user_id'   => $user['id'],
                    'username'  => $user['username'],
                    'role'      => $user['role'],
                    'logged_in' => true
                ]);

                return redirect()->to('/dashboard'); // Go to dashboard method
            }

            return redirect()->back()->with('error', 'Invalid email or password');
        }

        // Show login form on GET
        return view('auth/login');
    }

    // Register (default role = student)
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
                'role'     => 'student' // force default role
            ];

            // Try saving
            if ($userModel->save($data)) {
                $userId = $userModel->getInsertID();

                session()->set([
                    'user_id'   => $userId,
                    'username'  => $data['username'],
                    'role'      => $data['role'],
                    'logged_in' => true
                ]);

                return redirect()->to('/dashboard')->with('success', 'Registration successful. You are now logged in.');
            } else {
                // Show DB/validation errors
                return redirect()->back()->with('error', 'Registration failed. ' . implode(', ', $userModel->errors()));
            }
        }
    }

    // Logout
    public function logout()
    {
        session()->destroy();
        return redirect()->to('login');
    }

    // Dashboard with role-based redirect
    public function dashboard()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('login')->with('error', 'Please login first.');
        }

        $role = session()->get('role');

        if ($role === 'admin') {
            return redirect()->to('/admin/dashboard');
        } elseif ($role === 'teacher') {
            return redirect()->to('/teacher/dashboard');
        } elseif ($role === 'student') {
            return redirect()->to('/student/dashboard');
        }

        // Fallback
        return redirect()->to('dashboard');
    }
}
