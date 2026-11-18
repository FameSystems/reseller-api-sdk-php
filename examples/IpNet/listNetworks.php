<?php
require __DIR__ . '/../../vendor/autoload.php';

use FameSystems\ResellerAPI\ResellerAPI;

$resellerAPI = new ResellerAPI('');
$response = $resellerAPI->ipnet->listNetworks();

if ($response->getStatus() == 'success') {
    foreach ($response->data->networks as $network) {
        echo '#' . $network->productId . ' ' . $network->cidr . ' (' . $network->entryCount . ' Einträge)';
        echo $network->cancelled ? ' gekündigt zum ' . $network->contractEnd : '';
        echo '<br>';
    }
} else {
    echo "Error: " . $response->messages->errors[0]->message;
}
