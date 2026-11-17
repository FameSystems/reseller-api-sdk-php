<?php
// Load the KVM configurator options and get the price of a configuration.
// Nothing is ordered. Docs: https://docs.resellerapi.de/kvm/api/

require __DIR__.'/../../vendor/autoload.php';

use FameSystems\ResellerAPI\ResellerAPI;


$resellerAPI = new ResellerAPI('');

// Processors, limits, prices and operating systems
$options = $resellerAPI->kvm->configuratorOptions();
if ($options->getStatus() !== 'success') {
    echo 'Error: ' . $options->getMessages()->errors[0]->message;
    exit;
}

echo 'Price class: ' . $options->getData()->priceClass->name . '<br>';
foreach ($options->getData()->cpuTypes as $cpu) {
    echo $cpu->cpuTypeId . ': ' . $cpu->name . ' (from ' . $cpu->priceMonthlyFrom . ' EUR/month)<br>';
}

// Binding price of a configuration
$quote = $resellerAPI->kvm->configuratorQuote([
    'cpu_type_id' => $options->getData()->cpuTypes[0]->cpuTypeId,
    'cores'       => 2,
    'ram'         => 4,
    'disk'        => 50,
    'ipv4'        => 1,
    'backups'     => 3,
    'os_id'       => $options->getData()->osTemplates[0]->osId,
    'runtime'     => 1,
]);

if ($quote->getStatus() === 'success') {
    echo 'Price: ' . $quote->getData()->priceMonthly . ' EUR net per month<br>';
    foreach ($quote->getData()->breakdown as $line) {
        echo '- ' . $line->key . ': ' . $line->priceMonthly . ' EUR<br>';
    }
} else {
    echo 'Error: ' . $quote->getMessages()->errors[0]->message;
}
