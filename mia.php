<?php

// print_r($_GET);
// exit;




// Allow from any origin
if (isset($_SERVER['HTTP_ORIGIN'])) {
    // Decide if the origin in $_SERVER['HTTP_ORIGIN'] is one
    // you want to allow, and if so:
    header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
    header('Access-Control-Allow-Credentials: true');
    header('Access-Control-Max-Age: 86400');    // cache for 1 day
}
// Access-Control headers are received during OPTIONS requests
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD'])) {
        // may also be using PUT, PATCH, HEAD etc
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
    }
    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS'])) {
        header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
    }
    exit(0);
}


//
// load files
//
require __DIR__ . '/php/config.php';
require __DIR__ . '/php/functions.php';
require __DIR__ . '/php/pprint.php';

require __DIR__ . '/vendor/autoload.php';

//
// define global vars
//
$response = [];
$response['JSONoutput'] = true;
$response['status'] = 200;
$response['message'] = '';

if (isset($_GET['debug'])) {
    $response['JSONoutput'] = false;
}



//
// parse URL and create array with endpoint,value & ext_1
//
$url = getEndpoint();
$response['url'] = $url;
// pprint($url, 'Endpoint');



//
// get params from json or POST
//
$request = parseRequest();
$response['request'] = $request;
// pprint($request);



//
// make database connection & load utiliti functions
//
RedBeanPHP\R::setup('sqlite:db/'.$conf['DB_filename']);
require __DIR__ . '/php/functionsDB.php';

//
// switch between development & production mode
//
if ($conf['prod']) {
    RedBeanPHP\R::freeze(true);
}

//
// debug shows redbean queries
//
if (isset($_GET['debug']) && $_GET['debug']==='rb') {
    RedBeanPHP\R::fancyDebug();
}


//
// load file for current endpoint
//
switch ($url['endpoint']) {
    //
    // special case for login, because we have no token
    //
    case 'login':
        require 'endpoints/login.php';
        break;
        exit;
    case 'initDB':
        require 'endpoints/initDB.php';
        break;
        exit;
        //
        // search for file in endpoints
        //
    default:
        if (file_exists('endpoints/'.$url['endpoint'].'.php')) {
            //
            // verify JWT from barier and get user properties
            //
            $jwt ="eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdGFmZl9pZCI6OCwicm9sZSI6MCwicGVybWlzc2lvbiI6MH0.tzH7VLleNEIq2pJM6tuLs2M2icQoLqpTDqOhrjdMNYc";
            // $request['token'] = "xxx";
            // print_r($_SERVER['HTTP_AUTHORIZATION']);
            // exit;


            // if (! preg_match('/Bearer\s(\S+)/', $_SERVER['HTTP_AUTHORIZATION'], $matches)) {
            //     header('HTTP/1.0 400 Bad Request');
            //     echo 'Token not found in request';
            //     exit;
            // }

            // $jwt = $matches[1];
            // if (! $jwt) {
            //     // No token was able to be extracted from the authorization header
            //     header('HTTP/1.0 400 Bad Request');
            //     echo "2";
            //     exit;
            // }

            $jwt = explode(' ', $_SERVER['HTTP_AUTHORIZATION'])[1];
            // echo $jwt;
            $user = readJWT($jwt);
            $response['user'] = $user;
            // pprint($user, 'User');
            // $payload = ['staff_id' => 8,'role' => 0,'permission' => 0];
            // pprint(generateJWT($payload));




            //
            // call endpointfile
            //
            require 'endpoints/'.$url['endpoint'].'.php';
            exit;
        }

        //
        // throw error if no endpoint found
        //
        else {
            echo "no such endpoint";
        }
        break;
}
