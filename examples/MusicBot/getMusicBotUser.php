<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require __DIR__.'/../../vendor/autoload.php';

use FameSystems\ResellerAPI\Client;
use FameSystems\ResellerAPI\ResellerAPI;

$resellerAPI = new ResellerAPI('');
$response = $resellerAPI->musicbot->getAccount(0);

if($response->getStatus() == 'success') {

    $musicbotAccount = $response->musicBotUser;

    echo "User ID: " . $musicbotAccount->id . '<br>';
    echo "Username: " . $musicbotAccount->username . '<br>';
    echo "Email: " . $musicbotAccount->email . '<br>';
    echo "Storage: " . $musicbotAccount->storage . '<br>';
    echo "Number of Bots: " . $musicbotAccount->bots . '<br>';
    echo "Enabled: " . ($musicbotAccount->enabled ? 'true' : 'false') . '<br>';
    echo "Updated: " . $musicbotAccount->updated->format('Y-m-d H:i:s') . '<br>';
    echo "Created: " . $musicbotAccount->created->format('Y-m-d H:i:s') . '<br>';
}else{
    echo "Error: " . $response->messages->errors[0]->message;
}


$responseUsage = $resellerAPI->musicbot->getAccountUsage('');

if($responseUsage->getStatus() == 'success') {
    $musicbotAccountUsage = $responseUsage->musicBotUserUsage;

    echo "<br><br>Usage Information:<br>";
    echo "Storage Allowed: " . $musicbotAccountUsage->storage . ' MB<br>';
    echo "Total Storage Used: " . $musicbotAccountUsage->usedStorage . ' MB<br>';
    echo "Total Bots Active: " . $musicbotAccountUsage->usedBots . '<br>';
    echo "Total Bots Allowed: " . $musicbotAccountUsage->bots . '<br>';
    echo "Storage Usage Percentage: " . $musicbotAccountUsage->usedStoragePercentage . ' %<br>';
    echo "Bots Usage Percentage: " . $musicbotAccountUsage->usedBotsPercentage . ' %<br>';
}

?>