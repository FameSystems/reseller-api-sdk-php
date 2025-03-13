<?php

namespace FameSystems\ResellerAPI\Models\ApiResponse\Domain;

use FameSystems\ResellerAPI\Models\ApiResponse;

class checkDomainApiResponse extends ApiResponse {
    public string $domain;
    public string $tld;
    public string $status;
    public bool $domainAvailable;
    public bool $isPremiumName;
    public float $premiumRegistrationPrice;
    public float $premiumRenewPrice;
    public float $premiumTransferPrice;

    public function __construct($requestId, $status,$data, $messages, ?int $errorCode = null) {
        parent::__construct($requestId, $status, $data, $messages, $errorCode);

        // Mapping the domain-specific fields
        $this->domain = $data->domain;
        $this->tld = $data->tld;
        $this->status = $data->status;
        $this->domainAvailable = boolval($data->domain_available);
        $this->isPremiumName = boolval($data->isPremiumName);
        $this->premiumRegistrationPrice = $data->premiumRegistrationPrice;
        $this->premiumRenewPrice = $data->premiumRenewPrice;
        $this->premiumTransferPrice = $data->premiumTransferPrice;
    }
}

?>