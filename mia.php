<?php




if (isset($_SERVER['HTTP_ORIGIN'])) {
    header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
    header('Access-Control-Allow-Credentials: true');
    header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization');
    header('Access-Control-Max-Age: 86400');
}
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD'])) {
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
require __DIR__ . '/php/functionsDB.php';
require __DIR__ . '/vendor/autoload.php';

pprint($_SERVER);

//
// define global vars
//
$response = [];
$response['data'] = '';
$response['JSONoutput'] = true;
$response['status'] = 200;
$response['message'] = '';

//
// for debug mode disable the JSON header
//
if (isset($_GET['debug'])) {
    $response['JSONoutput'] = false;
}



//
// parse URL and create array with endpoint,value as first named keys
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
// make database connection
//
RedBeanPHP\R::setup('sqlite:db/'.$conf['DB_filename']);



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
    // special case for login, because we not have a token yet
    //
    case 'login':
        require 'endpoints/login.php';
        break;
        exit;
        //
        // special case to load the init function
        //
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
            // get and read the JWT and create the user array of it
            //
            $jwt = explode(' ', $_SERVER['HTTP_AUTHENTICATION'])[1];
            $user = readJWT($jwt);
            $response['user'] = $user;


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
            $response['status'] = 400;
            $response['message'] = 'no such endpoint';
            returnJSON($response);
        }
        break;
}