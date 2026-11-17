<?php
// Show an ordered KVM server, restart it and create a backup.
// Docs: https://docs.resellerapi.de/kvm/management/

require __DIR__.'/../../vendor/autoload.php';

use FameSystems\ResellerAPI\ResellerAPI;


$resellerAPI = new ResellerAPI('');
$serverId = 1337;

$server = $resellerAPI->kvm->getServer($serverId);
if ($server->getStatus() !== 'success') {
    echo 'Error: ' . $server->getMessages()->errors[0]->message;
    exit;
}

// setup/install while the server is being set up, active afterwards
echo 'Hostname: ' . $server->getData()->hostname . '<br>';
echo 'State: ' . ($server->getData()->state ?? 'active') . '<br>';

if (($server->getData()->state ?? 'active') !== 'active') {
    echo 'The server is still being set up.';
    exit;
}

$restart = $resellerAPI->kvm->restart($serverId);
echo 'Restart: ' . $restart->getStatus() . '<br>';

$backup = $resellerAPI->kvm->createBackup($serverId, 'Before update');
echo 'Backup: ' . $backup->getStatus() . '<br>';
