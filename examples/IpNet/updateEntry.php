<?php
require __DIR__ . '/../../vendor/autoload.php';

use FameSystems\ResellerAPI\ResellerAPI;
use FameSystems\ResellerAPI\Routes\IpNet;

$resellerAPI = new ResellerAPI('');

// Nur übergebene Felder ändern sich. null = unverändert, '' = leeren.
$response = $resellerAPI->ipnet->updateEntry(
    42,
    '45.91.251.200',
    'mail.example.com',
    'Mailserver Kunde 1001',
    IpNet::STATUS_IN_USE
);

if ($response->getStatus() == 'success') {
    echo 'Gespeichert: ' . $response->data->ip . ' rDNS ' . $response->data->rdns;
} else {
    echo "Error: " . $response->messages->errors[0]->message;
}
