<?php

namespace FameSystems\ResellerAPI\Models\ApiResponse\Domain;

class DomainCheck {
    public string $domain;
    public string|null $tld;
    public string $status;
    public bool $domainAvailable;
    public bool $isPremiumName;
    public float $premiumRegistrationPrice;
    public float $premiumRenewPrice;
    public float $premiumTransferPrice;

    public function __construct($domainData) {
        $this->domain = $domainData->domain;
        $this->tld = $domainData->tld ?? null;
        $this->status = $domainData->status;
        $this->domainAvailable = boolval($domainData->domain_available) ?? false;
        $this->isPremiumName = boolval($domainData->isPremiumName) ?? false;
        $this->premiumRegistrationPrice = $domainData->premiumRegistrationPrice ?? 0.00;
        $this->premiumRenewPrice = $domainData->premiumRenewPrice ?? 0.00;
        $this->premiumTransferPrice = $domainData->premiumTransferPrice ?? 0.00;
    }
}

?>