<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require __DIR__.'/../../vendor/autoload.php';

use FameSystems\ResellerAPI\Client;
use FameSystems\ResellerAPI\ResellerAPI;



$resellerAPI = new ResellerAPI('');
$response = $resellerAPI->musicbot->createAccountLoginSession("");

if($response->status == 'success') {

    $musicbotAccountSession = $response->musicBotUserSession;

    echo "Session Token: " . $musicbotAccountSession->sessionId . '<br>';
    echo "Session Login URL: " . $musicbotAccountSession->loginUrl . '<br>';
    echo "Panel URL: " . $musicbotAccountSession->panelUrl . '<br>';
}else{
    echo "Error: " . $response->messages->errors[0]->message;
}

?>