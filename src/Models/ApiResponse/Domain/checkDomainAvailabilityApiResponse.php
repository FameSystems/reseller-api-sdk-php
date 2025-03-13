<?php

namespace FameSystems\ResellerAPI\Models\ApiResponse\Domain;

use FameSystems\ResellerAPI\Models\ApiResponse;

class checkDomainAvailabilityApiResponse extends ApiResponse {
    /** @var DomainCheck[] $domains */
    public array $domains;

    public function __construct($requestId, $status,$data, $messages, ?int $errorCode = null) {
        parent::__construct($requestId, $status, $data, $messages, $errorCode);

        // Mapping der Domain-spezifischen Felder
        $this->domains = array_map(function($domainData) {
            return new DomainCheck($domainData);  // Umwandlung von Domain-Daten in Domain-Objekte
        }, $data);
    }
}

?>