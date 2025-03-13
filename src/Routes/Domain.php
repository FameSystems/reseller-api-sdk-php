<?php


namespace FameSystems\ResellerAPI\Routes;

use FameSystems\ResellerAPI\Client;
use FameSystems\ResellerAPI\Models\ApiResponse;
use FameSystems\ResellerAPI\Models\ApiResponse\Domain\checkDomainApiResponse;
use FameSystems\ResellerAPI\Models\ApiResponse\Domain\getDomainDNSRecordsApiResponse;
use FameSystems\ResellerAPI\Models\ApiResponse\Domain\getNameServerApiResponse;
use FameSystems\ResellerAPI\Models\ApiResponseMapper;
use FameSystems\ResellerAPI\Models\ApiResponse\Domain\checkDomainAvailabilityApiResponse;

opcache_reset();

class Domain
{
    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Check domain availability
     *
     * @param string $domain
     * @return checkDomainApiResponse
     * @throws \Exception
     */
    public function checkDomain(string $domain): checkDomainApiResponse
    {
        return ApiResponseMapper::mapResponseToModel($this->client->post('domain/check',
            [
                'domain' => $domain
            ]), 'FameSystems\ResellerAPI\Models\ApiResponse\Domain\checkDomainApiResponse');
    }

    // Check domain availability with search term and TLD
    public function checkDomainAvailability(string $searchterm, array $tld): checkDomainAvailabilityApiResponse
    {
        return ApiResponseMapper::mapResponseToModel($this->client->post('domain/checkavailability',
            [
                'searchterm' => $searchterm,
                'tldstosearch' => json_encode($tld)
            ]), 'FameSystems\ResellerAPI\Models\ApiResponse\Domain\checkDomainAvailabilityApiResponse');
    }

    // Create domain handle
    public function createDomainHandle(string $gender, string $firstname, string $lastname, string $street, string $number, string $postcode, string $city, string $region, string $country_code, string $email, string|null $phone = null, string|null $company = null): ApiResponse
    {
        $gender = strtoupper($gender);
        if ($gender != 'MALE' && $gender != 'FEMALE') {
            $gender = 'MALE';
        }

        return $this->client->post('domain/handle/create', [
            'gender' => $gender,
            'firstname' => $firstname,
            'lastname' => $lastname,
            'street' => $street,
            'number' => $number,
            'postcode' => $postcode,
            'city' => $city,
            'region' => $region,
            'country_code' => $country_code,
            'email' => $email,
            'phone' => $phone,
            'company' => $company
        ]);
    }

    // Get domain nameservers
    public function getNameServers($domain): getNameServerApiResponse
    {
        return ApiResponseMapper::mapResponseToModel($this->client->get('domain/nameserver/show',
            ['domain' => $domain]
        ), 'FameSystems\ResellerAPI\Models\ApiResponse\Domain\getNameServerApiResponse');
    }

    // Set domain nameservers
    public function setNameServers($domain, ApiResponse\Domain\DomainNameServer $nameServer)
    {
        return $this->client->post('domain/nameserver', [
            'domain' => $domain,
            'ns1' => $nameServer->ns1,
            'ns2' => $nameServer->ns2,
            'ns3' => $nameServer->ns3,
            'ns4' => $nameServer->ns4,
            'ns5' => $nameServer->ns5
        ]);
    }

    public function getDomainDNSRecords($domain): getDomainDNSRecordsApiResponse
    {
        return ApiResponseMapper::mapResponseToModel($this->client->get('domain/dns/show',
            [
                'domain' => $domain
            ]), 'FameSystems\ResellerAPI\Models\ApiResponse\Domain\getDomainDNSRecordsApiResponse');
    }

    public function getEPPCode($domain): ApiResponse
    {
        return $this->client->get('domain/eppcode',
            [
                'domain' => $domain
            ]);
    }

    public function getDomainInfo($domain): ApiResponse
    {
        return $this->client->get('domain/info',
            [
                'domain' => $domain
            ]);
    }

    public function transferDomain($domain, $ownerC, $adminC, $techC, $zoneC, $ns1, $ns2, $authCode): ApiResponse
    {
        return $this->client->post('domain/transfer', [
            'domain' => $domain,
            'ownerC' => $ownerC,
            'adminC' => $adminC,
            'techC' => $techC,
            'zoneC' => $zoneC,
            'ns1' => $ns1,
            'ns2' => $ns2,
            'authCode' => $authCode
        ]);
    }

    public function registerDomain($domain, $ownerC, $adminC, $techC, $zoneC, $ns1, $ns2): ApiResponse
    {
        return $this->client->post('domain/create', [
            'domain' => $domain,
            'ownerC' => $ownerC,
            'adminC' => $adminC,
            'techC' => $techC,
            'zoneC' => $zoneC,
            'ns1' => $ns1,
            'ns2' => $ns2,
        ]);
    }

    public function extendDomain($domain): ApiResponse
    {
        return $this->client->post('domain/extend', [
            'domain' => $domain,
        ]);
    }

    public function getDomainLockStatus($domain): ApiResponse
    {
        return $this->client->get('domain/lock_state', [
            'domain' => $domain
        ]);
    }

    public function setLockState(string $domain, string $lockStatus): ApiResponse
    {
        return $this->client->post('domain/lock_state', [
            'domain' => $domain,
            'state' => $lockStatus
        ]);
    }

    public function setDNSRecords(string $domain, array $dnsrecords): ApiResponse
    {
        return $this->client->post('domain/dns', [
            'domain' => $domain,
            'records' => json_encode($dnsrecords)
        ]);
    }

    public function getDomainSuggestions(string $searchTerm, array $tldsToInclude): ApiResponse
    {
        return $this->client->post('domain/suggestions', [
            'searchterm' => $searchTerm,
            'tldstosearch' => json_encode($tldsToInclude)
        ]);
    }
}


?>