<?php

namespace FameSystems\ResellerAPI\Models\ApiResponse\Domain;

class DomainNameServer{
    public string $ns1 = "";
    public string $ns2 = "";
    public string $ns3 = "";
    public string $ns4 = "";
    public string $ns5 = "";

    public function __construct($domainData) {
        if(isset($domainData->ns1)){$this->ns1 = $domainData->ns1 ?? "";}
        if(isset($domainData->ns2)){$this->ns2 = $domainData->ns2 ?? "";}
        if(isset($domainData->ns3)){$this->ns3 = $domainData->ns3 ?? "";}
        if(isset($domainData->ns4)){$this->ns4 = $domainData->ns4 ?? "";}
        if(isset($domainData->ns5)){$this->ns5 = $domainData->ns5 ?? "";}
    }
}

?>