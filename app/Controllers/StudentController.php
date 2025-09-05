<?php

namespace App\Controllers;

class StudentController extends BaseController
{
    public function dashboard()
    {
        return view('student/dashboard');
    }
}
