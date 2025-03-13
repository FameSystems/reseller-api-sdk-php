<?php
/**
 * Copyright (C) 2022 - 2025 FameSystems GmbH & Co. KG
 *
 *  We do not want anyone to see our source code,
 *    but if for any reason our code is stolen or
 *    otherwise obtained, we want to have a license that
 *    does not allow disclosure of any kind.
 *
 *  - FameSystem Framework
 *
 *  - Project: reseller-api-sdk
 *  - Created: 31.01.2025 09:16
 *  - Author: @Rene (René Wittenberg)
 *
 */

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require __DIR__.'/../../vendor/autoload.php';

use FameSystems\ResellerAPI\Client;
use FameSystems\ResellerAPI\ResellerAPI;


$resellerAPI = new ResellerAPI('');
$response = $resellerAPI->domain->getNameServers('example.com');

echo 'NS1: ' . $response->nameServer->ns1 . '<br>';
echo 'NS2: ' . $response->nameServer->ns2 . '<br>';
echo 'NS3: ' . $response->nameServer->ns3 . '<br>';
echo 'NS4: ' . $response->nameServer->ns4 . '<br>';

echo '<hr>';


$responseRecords = $resellerAPI->domain->getDomainDNSRecords('example.com');
foreach ($responseRecords->records as $record){
    echo "Type: " . $record->type . '<br>';
    echo "Name: " . $record->name . '<br>';
    echo "Content: " . $record->content . '<br>';
    echo "Plain Content: " . $record->plain_content . '<br>';
    echo "TTL: " . $record->ttl . '<br>';
    echo "Priority: " . $record->priority . '<br>';
    echo "Weight: " . $record->weight . '<br>';
    echo "Port: " . $record->port . '<br>';

    echo '<hr>';
}

?>