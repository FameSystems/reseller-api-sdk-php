<?php

namespace FameSystems\ResellerAPI\Models\ApiResponse\Domain;

use FameSystems\ResellerAPI\Models\ApiResponse;


class getNameServerApiResponse extends ApiResponse {
    public DomainNameServer $nameServer;

    public function __construct($requestId, $status,$data, $messages, ?int $errorCode = null) {
        parent::__construct($requestId, $status, $data, $messages, $errorCode);

        $this->nameServer = new DomainNameServer($data);
    }
}

?>