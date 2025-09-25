<?php

namespace App\Controllers;

class TeacherController extends BaseController
{
    public function index()
    {
        // 1. Authorization check
        if(!session()->has('role') || session()->get('role') != 'teacher') {
            return redirect()->to('/unauthorized'); // or login page
        }

        // 2. Prepare dashboard data (example: teacher's courses)
        $data['courses'] = ['Math 101', 'Science 102', 'History 103'];

        // 3. Load the dashboard view
        return view('dashboards/teacher_dashboard', $data);
    }
}
