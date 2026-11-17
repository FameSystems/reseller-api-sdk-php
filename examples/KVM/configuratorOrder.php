<?php
// Order a KVM server via the configurator. Runs as a test order by default:
// every check including your credit, but nothing is created or charged.
// Docs: https://docs.resellerapi.de/kvm/api/

require __DIR__.'/../../vendor/autoload.php';

use FameSystems\ResellerAPI\ResellerAPI;


$resellerAPI = new ResellerAPI('');

$order = [
    'cpu_type_id' => 3,
    'cores'       => 2,
    'ram'         => 4,
    'disk'        => 50,
    'ipv4'        => 1,
    'backups'     => 3,
    'os_id'       => 18,
    'language'    => 'en',
    'runtime'     => 1,
    'hostname'    => 'server1',
    'password'    => 'Str0ngPassword!123',
    // Your own unique reference: retrying the same order never charges twice.
    'reference'   => 'my-shop-order-4711',
];

$testOnly = true;

$response = $testOnly
    ? $resellerAPI->kvm->configuratorOrderTest($order)
    : $resellerAPI->kvm->configuratorOrder($order);

if ($response->getStatus() === 'success') {
    echo 'Server ID: ' . $response->getData()->serverId . '<br>';
    echo 'Charged: ' . $response->getData()->price . ' EUR net<br>';
} else {
    echo 'Error: ' . $response->getMessages()->errors[0]->message;
}
