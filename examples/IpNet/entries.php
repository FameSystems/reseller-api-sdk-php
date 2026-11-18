<?php
require __DIR__ . '/../../vendor/autoload.php';

use FameSystems\ResellerAPI\ResellerAPI;

$resellerAPI = new ResellerAPI('');

// Seite 1 mit 50 Einträgen. Mit $search springt die API zur Seite einer Adresse.
$response = $resellerAPI->ipnet->entries(42, 1, 50);

if ($response->getStatus() == 'success') {
    foreach ($response->data->entries as $entry) {
        echo $entry->ip . ' | ' . $entry->status . ' | ' . $entry->rdns . ' | ' . $entry->description . '<br>';
    }
    echo 'Seite ' . $response->data->pagination->page . ' von ' . $response->data->pagination->totalPages;
} else {
    echo "Error: " . $response->messages->errors[0]->message;
}
