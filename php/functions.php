<?php

//
// time measurement
//
$start = microtime(true);


//
// Error handeling
//
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
ini_set("log_errors", 1);
if (is_file('./error.log')) {
    // unlink('./error.log');
}
ini_set("error_log", "./error.log");


/**
 * getEndpoint()
*
* It takes the URL and returns an array with the endpoint and value
*
* @return array with the endpoint, value, and ext_1.
*/
function getEndpoint()
{
    $uri               = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $uri               = explode('/', $uri);
    $api               = array_search('mia', $uri);
    // pprint($uri);

    $array = array_slice($uri, $api+1);
    $array = replace_key($array, 0, 'endpoint');
    $array = replace_key($array, 1, 'value');
    if (!isset($array['value'])) {
        $array['value'] = '';
    }
    $array['method'] = $_SERVER['REQUEST_METHOD'];

    return $array;
}

/**
 * parseRequest()
 *
 * It takes the request body and returns an associative array of the request parameters
 *
 * @return array the request.
 */
function parseRequest()
{
    $request = json_decode(file_get_contents('php://input'), true);
    if (!$request) {
        $request = $_POST;
    }
    return $request;
}



//
// JWT namespace
//
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

/**
 * generateJWT($payload)
 *
 * It generates a JWT token.
 *
 * @param payload The payload is the data that you want to send to the client.
 *
 * @return string A JWT token
 */
function generateJWT($payload)
{
    global $conf;

    // $payload['secretKey']  = 'bGS6lzFqvvSQ8ALbOxatm7/Vk7mLQyzqaS34Q4oR1ew=';
    $issuedAt              = new DateTimeImmutable();
    // $payload['issuedAt']   = $issuedAt;
    $payload['expire']     = $issuedAt->modify('+6 minutes')->getTimestamp();
    $payload['serverName'] = "your.domain.name";

    return JWT::encode($payload, $conf['JWTkey'], 'HS256');
}



/**
 * readJWT($jwt)
 *
 * It takes a JWT and returns an array of the data in the JWT
 *
 * @param jwt The JWT to decode.
 *
 * @return array of the decoded JWT.
 */
function readJWT($jwt)
{
    global $conf;
    $TOKEN = JWT::decode($jwt, new Key($conf['JWTkey'], 'HS256'));
    $TOKEN     = json_decode(json_encode($TOKEN), true);
    return (array) $TOKEN;
}




/**
 * replace_key($arr, $oldkey, $newkey)
 *
 * It takes an array, a key to replace, and a new key to replace it with.
 *
 * @param arr The array to be modified
 * @param oldkey The key you want to replace
 * @param newkey The new key you want to replace the old key with.
 *
 * @return array with the key replaced.
 */
function replace_key($arr, $oldkey, $newkey)
{
    if (array_key_exists($oldkey, $arr)) {
        $keys = array_keys($arr);
        $keys[array_search($oldkey, $keys)] = $newkey;
        return array_combine($keys, $arr);
    }
    return $arr;
}


///////////////////////////   HELPER    /////////////////////////////




/**
 * returnJSON($response)
 *
 * It takes a response array, adds some extra information to it, and then returns it as a JSON object
 *
 * @param array The response array that will be returned to the client.
 *
 * @return JSON The response is a JSON object with the following keys:
 */

function returnJSON($response)
{
    global $start;
    // access_log($response);

    // stop time measurement
    $response['exTime'] = round(1000*(microtime(true)-$start), 0).' ms';

    // send response as JSON
    if ($response['JSONoutput']) {
        unset($response['JSONoutput']);
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json; charset=UTF-8');
        header('Access-Control-Allow-Methods: POST');
        header('Access-Control-Max-Age: 3600');
        header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');
        echo json_encode($response);
    }
    // send response as text
    else {
        unset($response['JSONoutput']);
        pprint($response, 'response');
    }
    exit;
}






//
// maybe usefull
//
// pprint(get_declared_classes(),'get_declared_classes);
// pprint(sys_get_temp_dir(), 'sys_get_temp_dir');
