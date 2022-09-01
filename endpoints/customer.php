<?php

// secure file
if (!class_exists('RedBeanPHP\R')) {
    die('no direct loading allowed');
}
// get class
use RedBeanPHP\R as R;

/**
 * if no customer_id this endpoint will return a list of all customer from the current staff
 * with a customer_id it will return the data of this customer
 *
 * @param arrays $url, $user, $response
 *
 * @return JSON with customerdata
 */

//
// admin user get all customer
//
if ($user['role'] === "0" && !isset($url['value'])) {
    $allCustomer = R::getAll('SELECT * FROM customer');

    // collect keys
    $data = [];
    foreach ($allCustomer as &$customer) {
        $data[] = array_intersect_key($customer, array_flip(['id', 'name','email','phone','avatar','address']));
    }

    // ad data to response
    $response['data'] = $data;
    returnJSON($response);
}
//
// get a all customer from current staff
//
elseif (!isset($url['value'])) {
    $staff_id = $user['staff_id'];
    $allCustomer = R::getAll('SELECT * FROM customer WHERE staff_id = ?', [$staff_id]);

    // pprint($allCustomer);

    // if no customers found return to frontend
    if (empty($allCustomer)) {
        $response['data'] = '';
        $response['message'] = 'no customer found';
        returnJSON($response);
    }


    // collect keys
    $data = [];
    foreach ($allCustomer as &$customer) {
        $data[] = array_intersect_key($customer, array_flip(['id', 'name','email','phone','avatar','address']));
    }


    // ad data to response
    $response['data'] = $data;

    // return data to frontend
    returnJSON($response);
}

//
// get full data of single customer
//
elseif (is_numeric($url['value'])) {
    $customer = R::load('customer', $url['value']);
    if ($customer) {
        $data = $customer->export();
        unset($data['password']);

        $response['data'][0] = $data;
        returnJSON($response);
    }
}

//
// if nothing found, return message
//
else {
    $response['data'] = '';
    $response['status'] = 400;
    $response['message'] = 'no customer data found';
    returnJSON($response);
}





// function getCustomer($id)
// {
//     $customer = R::load('customer', $id);
//     $data = $customer->export();
//     unset($data['password']);
//     return $data;
// }