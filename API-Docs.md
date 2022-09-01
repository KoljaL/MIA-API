# API-Docs
 
 
## index.html

### `localStorage.getItem('MIA_token')`  
check on pageload if there is a token, then show content  
usefull for page reloads  

### `submitLogin(form)`  
send LogInForm data via POST to API  
**param** ` FormData  
@request token  

### `storeUserAuth(token)`  
decode the payload of the token and stores everyting in localsorage  
**param** ` token  

### `logout()`  
removes all entries from localStorage  
 
 
## endpoints/login.php

### `login($request)`  
Search fur user in DB & try to verify password, then generates an JWT with userdata as payload  
**param** ` request ` The $request array with login data.  
**return** ` JSON ` The response is a JSON object with JWT token contains userdata as base64(payload):  
 
 
## endpoints/customer.php
if no customer_id this endpoint will return a list of all customer from the current staff  
with a customer_id it will return the data of this customer  
**param** ` arrays ` $url, $user, $response  
**return** ` JSON ` with customerdata  
 
 
## endpoints/profile.php
if no customer_id this endpoint will return a list of all customer from the current staff  
with a customer_id it will return the data of this customer  
**param** ` arrays ` $url, $user, $response  
**return** ` JSON ` with customerdata  
 
 
## php/functions.php

### `getEndpoint()`  
It takes the URL and returns an array with the endpoint and value  
**return** ` array ` with the endpoint, value, and ext_1.  

### `parseRequest()`  
It takes the request body and returns an associative array of the request parameters  
**return** ` array ` the request.  

### `generateJWT($payload)`  
It generates a JWT token.  
**param** ` payload ` The payload is the data that you want to send to the client.  
**return** ` string ` A JWT token  

### `readJWT($jwt)`  
It takes a JWT and returns an array of the data in the JWT  
**param** ` jwt ` The JWT to decode.  
**return** ` array ` of the decoded JWT.  

### `replace_key($arr, $oldkey, $newkey)`  
It takes an array, a key to replace, and a new key to replace it with.  
**param** ` arr ` The array to be modified  
**param** ` oldkey ` The key you want to replace  
**param** ` newkey ` The new key you want to replace the old key with.  
**return** ` array ` with the key replaced.  

### `returnJSON($response)`  
It takes a response array, adds some extra information to it, and then returns it as a JSON object  
**param** ` array ` The response array that will be returned to the client.  
**return** ` JSON ` The response is a JSON object with the following keys:  
 
 
## php/functionsDB.php

### `getProjectsFromCustomer($id)`  
It returns an array of all the projects that belong to a customer  
**param** ` id ` The id of the customer  
**return** ` array ` of projects  
