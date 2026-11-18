<?php
require __DIR__ . '/../../vendor/autoload.php';

use FameSystems\ResellerAPI\Constants\ApiResponseCodes;
use FameSystems\ResellerAPI\ResellerAPI;

$resellerAPI = new ResellerAPI('');
$response = $resellerAPI->ipnet->blacklistScan(42);

if ($response->getStatus() == 'success') {
    $last = $response->data->last;
    echo $last->checked . ' Adressen geprüft, ' . $last->listed . ' gelistet';
} elseif ($response->messages->errors[0]->code == ApiResponseCodes::COOLDOWN_ACTIVE) {
    // Einmal je Stunde und Netz, gemeinsam mit dem Webinterface.
    echo 'Erst wieder in ' . $response->data->retryAfter . ' Sekunden möglich.';
} else {
    echo "Error: " . $response->messages->errors[0]->message;
}
