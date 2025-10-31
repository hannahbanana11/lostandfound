<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

// Authentication routes (system logic: role-based redirect)
$routes->get('/auth', 'Auth::index');
$routes->get('/auth/register', 'Auth::register');
$routes->post('/auth/save', 'Auth::save');
$routes->post('/auth/login', 'Auth::login');
$routes->get('/auth/logout', 'Auth::logout');

// Dashboard routes (role-based: admin → Admin Dashboard, user → User Dashboard)
$routes->get('/dashboard', 'Dashboard::index');

// User module routes (posting found items)
$routes->get('/dashboard/report', 'Dashboard::report');
$routes->post('/dashboard/report', 'Dashboard::report');

// Admin module routes (pending reports, approval, claim process)
$routes->get('/dashboard/approve/(:num)', 'Dashboard::approve/$1');
$routes->get('/dashboard/reject/(:num)', 'Dashboard::reject/$1');
$routes->get('/dashboard/claim/(:num)', 'Dashboard::showClaimForm/$1');
$routes->post('/dashboard/claim/(:num)', 'Dashboard::processClaim/$1');
$routes->get('/dashboard/approve-claim/(:num)', 'Dashboard::approveClaim/$1');
$routes->get('/dashboard/reject-claim/(:num)', 'Dashboard::rejectClaim/$1');

// Public timeline route (approved items only)
$routes->get('/timeline', 'Timeline::index');
$routes->get('/timeline/claim/(:num)', 'Timeline::showClaimForm/$1');
$routes->post('/timeline/claim', 'Timeline::processClaim');
$routes->get('/timeline/cancel-claim/(:num)', 'Timeline::cancelClaim/$1');

// Test accounts routes (for easy testing)
$routes->get('/test-accounts', 'TestAccounts::index');
$routes->get('/test-accounts/create', 'TestAccounts::createTestAccounts');
$routes->get('/test-accounts/login-admin', 'TestAccounts::loginAsAdmin');
$routes->get('/test-accounts/login-user', 'TestAccounts::loginAsUser');
$routes->get('/test-accounts/logout', 'TestAccounts::logout');

// Test data routes (for demonstration)
$routes->get('/test-data/create', 'TestData::create');
$routes->get('/test-data/clear', 'TestData::clear');

// Test routes
$routes->get('/test', 'Test::index');
$routes->get('/testdashboard', 'TestDashboard::test');
