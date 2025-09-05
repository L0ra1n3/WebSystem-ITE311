<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        return view( 'index');   // loads app/Views/index.php
    }

    public function about(): string
    {
        return view('about');   // loads app/Views/about.php
    }

    public function contact(): string
    {
       return view('contact');
    }
    
}
