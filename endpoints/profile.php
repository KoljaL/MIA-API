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
// id no value isset, get own profile
//
if ($url['value'] === '') {
    $user_id =   $user['user_id'];
    $user_data = R::load('user', $user_id);



    // convert to array
    $user_data = $user_data->export();

    // remove password
    unset($user_data['password']);

    // ad data to response
    $response['data'] = $user_data;

    // return data to frontend
    returnJSON($response);
}


//
// is is admin, get profile of user_id by value
//
elseif ($user['role'] === 'admin') {
    $user_id = $url['value'];
    $user_data = R::load('user', $user_id);


    // if no customers found return to frontend
    if (empty($user_data)) {
        $response['message'] = 'no staff found';
        returnJSON($response);
    }


    $user_data = $user_data->export();
    unset($user_data['password']);
    $response['data'] = $user_data;

    returnJSON($response);
}


//
// if current user is not admin & value is not empty
//
else {
    $response['status'] = 400;
    $response['message'] = 'not allowed to see';
    returnJSON($response);
}