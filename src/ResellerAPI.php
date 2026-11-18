<?php

namespace FameSystems\ResellerAPI;

use FameSystems\ResellerAPI\Routes\Account;
use FameSystems\ResellerAPI\Routes\Domain;
use FameSystems\ResellerAPI\Routes\IpNet;
use FameSystems\ResellerAPI\Routes\KVM;
use FameSystems\ResellerAPI\Routes\Musicbot;
use FameSystems\ResellerAPI\Routes\Plesk;

/**
 *
 */
class ResellerAPI{

    public Client $client;
    public Account $account;
    public Domain $domain;
    public Plesk $plesk;

    public Musicbot $musicbot;

    public KVM $kvm;

    public IpNet $ipnet;

    /**
     * @param string $token
     * @param string|null $apiUrl
     * @param string|null $userAgent
     */
    public function __construct(string $token, string|null $apiUrl = null, string|null $userAgent = null) {
         $this->client = new Client($token, $apiUrl, $userAgent);
         $this->account = new Account($this->client);
         $this->domain = new Domain($this->client);
         $this->plesk = new Plesk($this->client);
         $this->musicbot = new Musicbot($this->client);
         $this->kvm = new KVM($this->client);
         $this->ipnet = new IpNet($this->client);
     }

}
