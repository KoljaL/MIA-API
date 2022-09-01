<?php

// secure file
if (!class_exists('RedBeanPHP\R')) {
    die('no direct loading allowed');
}
// get class
use RedBeanPHP\R as R;

switch ($url['method']) {
    case 'POST':
        $response = login($request);
        returnJSON($response);
        break;

    default:
        $response['data'] = '';
        $response['status'] = 400;
        $response['message'] = 'wrong method';
        returnJSON($response);
        break;
}

/**
 * login($request)
 *
 * Search fur user in DB & try to verify password, then generates an JWT with userdata as payload
 *
 * @param request The $request array with login data.
 *
 * @return JSON The response is a JSON object with JWT token contains userdata as base64(payload):
 */

function login($request)
{
    global $response;
    //
    // find staff in database by email
    //
    $user  = R::findOne('user', ' email = ?', [ $request['email']]);
    if ($user) {
        $user = $user->export();

        //
        // verify password & get userdata for payload
        //
        if (password_verify($request['password'], $user['password'])) {
            $payload = [
                'user_id' => $user['id'],
                'username'=> $user['name'],
                'role' => $user['role'],
                'avatar' => $user['avatar'],

            ];
        }
        //
        // return message if password is wrong
        //
        else {
            $response['data'] = '';
            $response['status'] = 400;
            $response['message'] = 'wrong password';
            return $response;
        }
    }
    //
    // return message if no user found
    //
    else {
        $response['data'] = '';
        $response['status'] = 400;
        $response['message'] = 'no user found';
        return $response;
    }

    //
    // Generate a JWT token.
    //
    $jwt = generateJWT($payload);


    //
    // return JWT
    //
    if ($jwt) {
        $response['data'] = $jwt;
        return $response;
    }
    //
    // return message if no JWT was generated
    //
    else {
        $response['data'] = '';
        $response['status'] = 400;
        $response['message'] = 'no JWT was generated';
        return $response;
    }
}