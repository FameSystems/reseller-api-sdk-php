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
 *  - Created: 31.01.2025 09:10
 *  - Author: @Rene (René Wittenberg)
 *
 */

namespace FameSystems\ResellerAPI\Models\ApiResponse\Domain;


class dnsRecord{
    public string $type;
    public string $name;
    public string $content;
    public string $plain_content;
    public int $ttl;
    public int|null $priority = null;
    public int|null $weight = null;
    public int|null $port = null;

    public function __construct($type, $name, $content,$plain_content, $ttl, $priority = null, $weight = null, $port = null) {
        $this->type = $type;
        $this->name = $name;
        $this->content = $content;
        $this->plain_content = $plain_content;
        $this->ttl = $ttl;
        if($priority != null){$this->priority = $priority;}
        if($weight != null){$this->weight = $weight;}
        if($port != null){$this->port = $port;}
    }


}


?>