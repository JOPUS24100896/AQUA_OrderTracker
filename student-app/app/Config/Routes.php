<?php

use App\Controllers\OrdersOperation;
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('products', 'Products::index');
$routes->get('products/create', 'Products::create');
$routes->post('products/store', 'Products::store');
$routes->get('products/delete', 'Products::delData');
$routes->post('products/deleteProd', 'Products::delete');


//GENERAL
$routes->get('orders/manageProf', 'OrderViews::manageProf');
$routes->get('orders/contactInfo', 'OrderViews::contactInfo');
$routes->get('orders', 'OrderViews::index');
$routes->get('orders/privPolicy', 'OrderViews::privPolicy');
$routes->get('orders/signup', 'OrderViews::signUp');
$routes->get('orders/endSess', 'OrderViews::endSession');
    //ACCOUNT
$routes->post('orders/signUpUser', 'AccountManagement::signUp');
$routes->post('orders/logInUser', 'AccountManagement::login');
    //ORDERING
$routes->post("orders/create/makeOrder", 'OrdersOperation::makeOrder');
$routes->post("orders/update/orderStatus", 'OrdersOperation::updateStatus');




//STAFF
$routes->get('orders/staff/manageOrders', 'OrderViews::manageOrders');
$routes->get('orders/staff/orderRec', 'OrderViews::orderRecStaff');
$routes->get('orders/staff/order', 'OrderViews::makeOrderStaff');
$routes->get('orders/staff/deliveries', 'OrderViews::deliv');

//CUST
$routes->get('orders/cust/order', 'OrderViews::makeOrderCust');
$routes->get('orders/cust/pending', 'OrderViews::orderHistoryCust');
$routes->get('orders/cust/history', 'OrderViews::allOrdersCust');

//ADMIN
$routes->get('orders/admin/inventory', 'OrderViews::inventoryAdmin');
$routes->get('/orders/admin/orderGraph', 'OrderViews::orderGraphAdmin');
$routes->get('/orders/admin/graphData', 'OrderViews::graphData');
$routes->get('orders/admin/orderRecord', 'OrderViews::orderRecordAdmin');
$routes->post('/api/add-stock', 'OrderViews::addStock');
$routes->get('posts', 'PostController::index');






