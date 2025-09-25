<?php

namespace App\Controllers;

class StudentController extends BaseController
{
    public function index()
    {
        // 1. Authorization check
        if(!session()->has('role') || session()->get('role') != 'student') {
            return redirect()->to('/unauthorized'); // or login page
        }

        // 2. Prepare dashboard data (example: enrolled courses)
        $data['enrollments'] = ['Math 101', 'English 101', 'PE 101'];

        // 3. Load the dashboard view
        return view('dashboard/student', $data);

    }
}
