<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require __DIR__.'/../../vendor/autoload.php';

use FameSystems\ResellerAPI\Client;
use FameSystems\ResellerAPI\ResellerAPI;

$resellerAPI = new ResellerAPI('');
$response = $resellerAPI->musicbot->createAccount('username', 'email@email.de','password', 5000, 1);

var_dump($response);


?>