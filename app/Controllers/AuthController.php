<?php

namespace App\Controllers;

use App\Models\UserModel;

class AuthController extends BaseController
{
    // Show login form
    public function login()
    {
        return view('auth/login');
    }

    // Authenticate user
    public function auth()
    {
        $userModel = new UserModel();
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $user = $userModel->where('email', $email)->first();

        if ($user && password_verify($password, $user['password'])) {
            // Set session
            session()->set([
                'user_id'   => $user['id'],
                'username'  => $user['username'],
                'role'      => $user['role'],
                'logged_in' => true
            ]);

            // Redirect based on role
if ($user['role'] === 'admin') {
    return redirect()->to('/admin/dashboard');
} elseif ($user['role'] === 'staff') {
    return redirect()->to('/staff/dashboard');
} elseif ($user['role'] === 'student') {
    return redirect()->to('/student/dashboard');
} elseif ($user['role'] === 'instructor') {
    return redirect()->to('/instructor/dashboard');
} elseif ($user['role'] === 'user') {
    return redirect()->to('/user/dashboard');
} else {
    return redirect()->to('/dashboard');
}


        }

        return redirect()->back()->with('error', 'Invalid email or password');
    }

    // Show register form
    public function register()
    {
        return view('auth/register');
    }

    // Store new user
    public function store()
    {
        $userModel = new UserModel();
    $data = [
    'username' => $this->request->getPost('username'),
    'email'    => $this->request->getPost('email'),
    'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
    'role'     => $this->request->getPost('role') // ✅ get role from dropdown
];
        $userModel->save($data);

        return redirect()->to('/login')->with('success', 'Registration successful. Please login.');
    }

    // Logout
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}
