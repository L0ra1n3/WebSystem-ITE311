<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
    
$routes->get('/', 'Home::index');   
$routes->get('/about', 'Home::about');  
$routes->get('/contact', 'Home::contact');

$routes->get('login', 'AuthController::login');
$routes->post('login', 'AuthController::auth');
$routes->get('register', 'AuthController::register');
$routes->post('register/store', 'AuthController::store');
$routes->get('logout', 'AuthController::logout');

$routes->get('admin/dashboard', 'AdminController::index');
$routes->get('user/dashboard', 'UserController::index');
$routes->get('/student/dashboard', 'StudentController::dashboard');
$routes->get('/instructor/dashboard', 'InstructorController::dashboard');   





