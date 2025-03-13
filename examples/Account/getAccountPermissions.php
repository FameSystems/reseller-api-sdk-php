<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require __DIR__.'/../../vendor/autoload.php';

use FameSystems\ResellerAPI\Client;
use FameSystems\ResellerAPI\ResellerAPI;


$resellerAPI = new ResellerAPI('');
$response = $resellerAPI->account->getPermissions();

if($response->getStatus() == 'success') {
    foreach ($response->data->permissions as $permission) {echo "permission: " . $permission . '<br>';}
}else{echo "Error: " . $response->messages->errors[0]->message;}

?>