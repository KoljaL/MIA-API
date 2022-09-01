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

$staff_id =   $user['staff_id'];
$staffData = R::getAll('SELECT * FROM staff WHERE id = ?', [$staff_id]);

// pprint($staffData);

// if no customers found return to frontend
if (empty($staffData)) {
    $response['data'] = '';
    $response['message'] = 'no staff found';
    returnJSON($response);
}

// remove some keys
// foreach ($staffData as &$customer) {
//     unset($customer['password']);
// }

// ad data to response
$response['data'] = $staffData;

// return data to frontend
returnJSON($response);


// if (is_numeric($url['value'])) {
//     $response['data'][0] = getCustomer($url['value']);
//     returnJSON($response);
// } else {
//     $response['data'] = '';
//     $response['status'] = 400;
//     $response['message'] = 'no numeric customer_id';
//     returnJSON($response);
// }





function getCustomer($id)
{
    $customer = R::load('customer', $id);
    $data = $customer->export();
    unset($data['password']);
    return $data;
}