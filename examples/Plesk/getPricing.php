<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require __DIR__.'/../../vendor/autoload.php';

use FameSystems\ResellerAPI\Client;
use FameSystems\ResellerAPI\ResellerAPI;


$resellerAPI = new ResellerAPI('');
$response = $resellerAPI->plesk->getPricing();

foreach ($response->licenses as $licens){
    echo "Type: " . $licens->getType() . '<br>';
    echo "Title: " . $licens->getTitle() . '<br>';
    echo "Group: " . $licens->getGroupName() . '<br>';
    echo "Price: " . $licens->getPrice() . '<br>';
    echo '<hr>';
}



?>