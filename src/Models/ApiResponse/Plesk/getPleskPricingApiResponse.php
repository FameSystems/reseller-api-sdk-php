<?php


namespace FameSystems\ResellerAPI\Models\ApiResponse\Plesk;

use FameSystems\ResellerAPI\Models\ApiResponse;

class getPleskPricingApiResponse extends ApiResponse {
    /** @var PleskLicenseType[] $licenses */
    public array $licenses;

    public function __construct($requestId, $status,$data, $messages, ?int $errorCode = null) {
        parent::__construct($requestId, $status, $data, $messages, $errorCode);

        // Mapping der Domain-spezifischen Felder
        $this->licenses = array_map(function($licenseData) {
            return new PleskLicenseType(
                $licenseData->type,
                $licenseData->title,
                $licenseData->group,
                $licenseData->price
            );
        }, $data);
    }
}


?>