<?php



/**
 *
 * title HTTP_ORIGIN & REQUEST_METHOD
 *
 * allows all origin & headers for API requests
 *
 * allow GET, POST & OPTIONS for METHOD & exit()
 *
 */
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

// pprint($_SERVER);

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


/**
 * getEndpoint()
 *
 * parse URL and create array with endpoint,value as first named keys
 *
 * @param URI $_SERVER['REQUEST_URI']
 *
 * @return array ['endpoint' => 'profile', 'value' => id, 2 => 'thirdparam', ...]
 */
$url = getEndpoint();
$response['url'] = $url;
// pprint($url, 'Endpoint');



/**
 * parseRequest()
 *
 * get params from json or POST
 *
 * @param file `php://input` or `$_POST`
 *
 * @return array the request.
 *
 */
$request = parseRequest();
$response['request'] = $request;
// pprint($request);



/**
 * title RedBeanPHP
 *
 * make database connection
 *
 * @param $conf['DB_filename']
 *
 */
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

/**
 * switch ($url['endpoint'])
 *
 * switch to endpoint file by endpoint param
 * special cases: `login` & `initDB`
 */
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
        /**
         *  if (file_exists('endpoints/'.$url['endpoint'].'.php'))
         *
         *  check if endpoint-file exists
         *
         * @param `$url['endpoint']`
         *
         * @return `endpoints/endpoint.php`
         *
         */
        if (file_exists('endpoints/'.$url['endpoint'].'.php')) {
            //
            // get and read the JWT and create the user array of it
            //
            /**
             * title get JWT from HTTP_AUTHENTICATION
             *
             * @param string $_SERVER['HTTP_AUTHENTICATION'])
             *
             * @return string $jwt
             */
            $jwt = explode(' ', $_SERVER['HTTP_AUTHENTICATION'])[1];


            /**
             * readJWT($jwt)
             *
             * get current user data (`id`, `role`, `permission`) from JWT
             * if JWT is invalid return error message
             *
             * @param string $jwt
             *
             * @return array $user
             */
            try {
                $user = readJWT($jwt);
            } catch (Exception $e) {
                $response['status'] = 400;
                $response['message'] = 'no valid token: '.$e->getMessage();
                returnJSON($response);
            }
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