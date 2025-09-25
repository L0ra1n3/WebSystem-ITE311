<?php

namespace App\Controllers;

class AdminController extends BaseController
{
    public function index()
    {
        
        if(session()->get('role') != 'admin') {
            return redirect()->to('/unauthorized'); 
        }

       
         $data['users'] = ['User1', 'User2', 'User3'];

        
        return view('dashboard/admin', $data);

    }
}
