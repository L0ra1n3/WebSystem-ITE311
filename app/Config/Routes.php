<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
    
// Public pages
$routes->get('/', 'Home::index');   
$routes->get('/about', 'Home::about');  
$routes->get('/contact', 'Home::contact');

// Auth routes
$routes->get('login', 'Auth::login');
$routes->post('login', 'Auth::login');
$routes->get('register', 'Auth::register');
$routes->post('register', 'Auth::register');
$routes->get('auth/logout', 'Auth::logout');

// Dashboard
$routes->get('dashboard', 'Auth::dashboard'); // unified dashboard route

// Course enrollment (AJAX)
$routes->post('course/enroll', 'Course::enroll');

// Student pages
$routes->get('student/courses', 'Student::myCourses');
$routes->get('student/assignments', 'Student::assignments');

// Teacher pages
$routes->get('teacher/classes', 'Teacher::classes');
$routes->get('teacher/grades', 'Teacher::grades');

// Admin pages
$routes->get('admin/users', 'Admin::users');
$routes->get('admin/reports', 'Admin::reports');

// Materials routes
$routes->get('/admin/course/(:num)/upload', 'Materials::upload/$1');
$routes->post('/admin/course/(:num)/upload', 'Materials::upload/$1');
$routes->get('/materials/delete/(:num)', 'Materials::delete/$1');
$routes->get('/materials/download/(:num)', 'Materials::download/$1');
