<?php

namespace FameSystems\ResellerAPI\Models;

use FameSystems\ResellerAPI\Constants\ApiResponseCodes;

class Error {
    public int $code;
    public string $message;
    public string|null $constantName;

    public function __construct(int $code, string $message) {
        $this->code = $code;
        $this->message = $message;
        $this->constantName = ErrorCodeResolver::getConstantName($code);
    }
}

?>