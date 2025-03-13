<?php

namespace FameSystems\ResellerAPI\Routes;
use FameSystems\ResellerAPI\Client;

class Account{
    private Client $client;

    public function __construct(Client $client) {
        $this->client = $client;
    }


    public function getBalance() {
        return $this->client->get('account/balance');
    }


    public function getPermissions() {
        return $this->client->get('account/permissions');
    }

}

?>