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
 *  - Created: 31.01.2025 09:14
 *  - Author: @Rene (René Wittenberg)
 *
 */

namespace FameSystems\ResellerAPI\Models\ApiResponse\Domain;

use FameSystems\ResellerAPI\Models\ApiResponse;


class getDomainDNSRecordsApiResponse extends ApiResponse {
    /** @var dnsRecord[] $records */
    public array $records;

    public function __construct($requestId, $status,$data, $messages, ?int $errorCode = null) {
        parent::__construct($requestId, $status, $data, $messages, $errorCode);

        // Mapping der Domain-spezifischen Felder
        $this->records = array_map(function($domainData) {
           try{
               return new dnsRecord(
                   $domainData->type,
                   $domainData->name,
                   $domainData->content,
                   $domainData->plain_content,
                   $domainData->ttl,
                   $domainData->priority,
                   $domainData->weight,
                   $domainData->port
               );
           }catch (\Throwable $throwable){}
        }, $data);
    }
}

?>