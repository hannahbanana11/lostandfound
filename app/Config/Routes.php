<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

// Authentication routes
$routes->get('/auth', 'Auth::index');
$routes->get('/auth/register', 'Auth::register');
$routes->post('/auth/save', 'Auth::save');
$routes->post('/auth/login', 'Auth::login');
$routes->get('/auth/logout', 'Auth::logout');

// Dashboard route
$routes->get('/dashboard', 'Dashboard::index');

// Timeline route
$routes->get('/timeline', 'Timeline::index');

// Test route
$routes->get('/test', 'Test::index');
