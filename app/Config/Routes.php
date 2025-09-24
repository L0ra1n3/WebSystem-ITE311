<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
    
$routes->get('/', 'Home::index');   
$routes->get('/about', 'Home::about');  
$routes->get('/contact', 'Home::contact');

// Auth routes
$routes->get('login', 'Auth::login');
$routes->post('login', 'Auth::login');  // ✅ fixed
$routes->get('register', 'Auth::register');
$routes->post('register', 'Auth::register');  // ✅ fixed
$routes->get('logout', 'Auth::logout');

// Unified dashboard (role-based redirect handled in controller)
$routes->get('dashboard', 'Auth::dashboard');

// Role-specific dashboards
$routes->get('admin/dashboard', 'AdminController::index');
$routes->get('user/dashboard', 'UserController::index');
$routes->get('student/dashboard', 'StudentController::dashboard');
$routes->get('teacher/dashboard', 'InstructorController::dashboard');
$routes->get('staff/dashboard', 'StaffController::dashboard'); // ✅ added missing staff route
