<?php

namespace App\Controllers;

class AdminController extends BaseController
{
    public function index()
    {
        // 1. Authorization check
        if(session()->get('role') != 'admin') {
            return redirect()->to('/unauthorized'); // or login page
        }

        // 2. Prepare dashboard data (optional)
         $data['users'] = ['User1', 'User2', 'User3'];

        // 3. Load the dashboard view
        return view('dashboard/admin', $data);

    }
}
