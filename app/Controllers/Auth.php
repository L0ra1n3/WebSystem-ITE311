<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    // ✅ LOGIN
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
                return redirect()->back()->with('error', '❌ Wrong password. Try: admin123 / teacher123 / student123');
            }

            // ✅ Login success: store session
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

    // ✅ REGISTER
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
                return redirect()->to('/login')
                                 ->with('success', 'Registration successful. Please login.');
            } else {
                return redirect()->back()
                                 ->with('error', 'Registration failed. ' . implode(', ', $userModel->errors()));
            }
        }
    }

    // ✅ DASHBOARD
    public function dashboard()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login')->with('error', 'Please login first.');
        }

        $role = session()->get('role');
        $name = session()->get('username');

        $data = [
            'role' => $role,
            'name' => $name,
        ];

        $courseModel = new \App\Models\CourseModel();
        $materialModel = new \App\Models\MaterialModel();

        // ✅ Load student-specific data
        if ($role === 'student') {
            $enrollmentModel = new \App\Models\EnrollmentModel();

            $data['enrollments'] = $enrollmentModel->getUserEnrollments(session()->get('user_id'));
            $data['courses']     = $courseModel->findAll();
            
            // Load materials for enrolled courses
            $data['materials'] = [];
            foreach($data['enrollments'] as $enrollment) {
                $courseMaterials = $materialModel->getMaterialsByCourse($enrollment['course_id']);
                if (!empty($courseMaterials)) {
                    $data['materials'][$enrollment['course_id']] = $courseMaterials;
                }
            }
        }

        // ✅ Load courses for teacher and admin
        if ($role === 'teacher' || $role === 'admin') {
            $data['courses'] = $courseModel->findAll();
            
            // Load all materials grouped by course
            $data['materials'] = [];
            foreach($data['courses'] as $course) {
                $courseMaterials = $materialModel->getMaterialsByCourse($course['id']);
                if (!empty($courseMaterials)) {
                    $data['materials'][$course['id']] = $courseMaterials;
                }
            }
        }

        // ✅ Load enrollments for teacher
        if ($role === 'teacher') {
            $enrollmentModel = new \App\Models\EnrollmentModel();
            $data['enrollments'] = $enrollmentModel->getAllEnrollmentsWithDetails();
        }

        return view('auth/dashboard', $data);
    }

    // ✅ LOGOUT
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login')->with('success', 'Logged out successfully.');
    }
}
