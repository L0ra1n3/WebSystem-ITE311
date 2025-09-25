<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
   
    public function login()
    {
       
        if (session()->get('logged_in')) {
            return redirect()->to('dashboard');
        }

       
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

                return redirect()->to('/dashboard'); 
            }

            return redirect()->back()->with('error', 'Invalid email or password');
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
                'role'     => 'student' // force default role
            ];

            
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
                
                return redirect()->back()->with('error', 'Registration failed. ' . implode(', ', $userModel->errors()));
            }
        }
    }

   
    public function logout()
    {
        session()->destroy();
        return redirect()->to('login');
    }

    
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

       
        return redirect()->to('dashboard');
    }
}
