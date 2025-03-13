<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require __DIR__.'/../../vendor/autoload.php';

use FameSystems\ResellerAPI\Client;
use FameSystems\ResellerAPI\ResellerAPI;


$resellerAPI = new ResellerAPI('');
$response = $resellerAPI->domain->checkDomain('example.com');

echo "Domain available: " . ($response->domainAvailable ? 'true' : 'false') . '<br>';
echo "Domain: " . $response->domain . '<br>';
echo "TLD: " . $response->tld . '<br>';
echo "Status: " . $response->status . '<br>';
echo "Is premium name: " . ($response->isPremiumName ? 'true' : 'false') . '<br>';
echo "Premium registration price: " . $response->premiumRegistrationPrice . '<br>';
echo "Premium renew price: " . $response->premiumRenewPrice . '<br>';
echo "Premium transfer price: " . $response->premiumTransferPrice . '<br>';

echo '<hr>';

$responseMultipleTld = $resellerAPI->domain->checkDomainAvailability('example', ['com', 'net', 'org']);
foreach ($responseMultipleTld->domains as $domain){
    echo "Domain available: " . ($domain->domainAvailable ? 'true' : 'false') . '<br>';
    echo "Domain: " . $domain->domain . '<br>';
    echo "TLD: " . $domain->tld . '<br>';
    echo "Status: " . $domain->status . '<br>';
    echo "Is premium name: " . ($domain->isPremiumName ? 'true' : 'false') . '<br>';
    echo "Premium registration price: " . $domain->premiumRegistrationPrice . '<br>';
    echo "Premium renew price: " . $domain->premiumRenewPrice . '<br>';
    echo "Premium transfer price: " . $domain->premiumTransferPrice . '<br>';

    echo '<hr>';
}


$nameServer = $resellerAPI->domain->getNameServers(strtolower('example.com'));

if ($nameServer->status != 'success') {
  echo $nameServer->getMessages()->errors[0]->message;
}else{
    echo "NS1: " . $nameServer->nameServer->ns1 . '<br>';
    echo "NS2: " . $nameServer->nameServer->ns2 . '<br>';
    echo "NS3: " . $nameServer->nameServer->ns3 . '<br>';
    echo "NS4: " . $nameServer->nameServer->ns4 . '<br>';
}


?>