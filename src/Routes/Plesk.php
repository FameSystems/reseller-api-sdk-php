<?php

namespace FameSystems\ResellerAPI\Routes;
use FameSystems\ResellerAPI\Client;
use FameSystems\ResellerAPI\Models\ApiResponse;
use FameSystems\ResellerAPI\Models\ApiResponseMapper;

class Plesk
{
    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }


    public function getPricing() : ApiResponse\Plesk\getPleskPricingApiResponse{
        return ApiResponseMapper::mapResponseToModel($this->client->get("plesk/pricing"),
            'FameSystems\ResellerAPI\Models\ApiResponse\Plesk\getPleskPricingApiResponse');
    }

    // duration is in months and must be between 1 and 12 months
    public function orderLicense($type,int $duration = 1,string $reference = "") : ApiResponse{
        return $this->client->post("plesk/license/create",
            [
                'type' => $type,
                'duration' => $duration,
                'reference' => $reference
            ]);
    }

    public function extendLicense(string $license,int $duration = 1) : ApiResponse{
        return $this->client->post("plesk/license/extend",
            [
                'license' => $license,
                'duration' => $duration,
            ]);
    }

    public function setLicenseBinding(string $license,string $ip_address, string $description = "") : ApiResponse{
        return $this->client->post("plesk/license/binding",
            [
                'license' => $license,
                'ip_address' => $ip_address,
                'description' => $description
            ]);
    }

    public function getLicenseReports(string $license) : ApiResponse{
        return $this->client->get("plesk/license/reports", [
            'license' => $license
        ]);
    }

    public function getLicense(string $license) : ApiResponse{
        return $this->client->get("plesk/license", [
            'license' => $license
        ]);
    }
}


?>