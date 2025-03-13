<?php
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

require __DIR__.'/../../vendor/autoload.php';

use FameSystems\ResellerAPI\Client;
use FameSystems\ResellerAPI\ResellerAPI;


$resellerAPI = new ResellerAPI('');
$response = $resellerAPI->account->getBalance();


if($response->getStatus() == 'success') {
    echo "balance: " . $response->data->balance . '<br>';
    echo "security_deposit: " . $response->data->security_deposit . '<br>';
    echo "currency: " . $response->data->currency . '<br>';
    echo "currency_symbol: " . $response->data->currency_symbol . '<br>';
    echo "credit_enabled: " . ($response->data->credit_enabled ? 'true':'false') . '<br>';
    echo "credit_limit: " . $response->data->credit_limit . '<br>';
    echo "credit_reserved: " . $response->data->credit_reserved . '<br>';
    echo "credit_available: " . $response->data->credit_available . '<br>';
}else{
    echo "Error: " . $response->messages->errors[0]->message;
}
?>