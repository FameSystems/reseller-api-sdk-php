<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require __DIR__.'/../../vendor/autoload.php';

use FameSystems\ResellerAPI\Client;
use FameSystems\ResellerAPI\ResellerAPI;



$resellerAPI = new ResellerAPI('');


// disable music bot account
//$response = $resellerAPI->musicbot->disableAccount('');
//var_dump($response);

// enable music bot account
//$response = $resellerAPI->musicbot->enableAccount('');
//var_dump($response);

// reset password
//$response = $resellerAPI->musicbot->setAccountPassword('', '');
//var_dump($response);

// delete music bot account
//$response = $resellerAPI->musicbot->deleteAccount('');
//var_dump($response);

?>