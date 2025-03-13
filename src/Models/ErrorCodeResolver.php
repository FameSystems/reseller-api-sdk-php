<?php

namespace FameSystems\ResellerAPI\Models;

use FameSystems\ResellerAPI\Constants\ApiResponseCodes;

class ErrorCodeResolver {
    public static function getConstantName($value): ?string {
        if(!(is_numeric($value))){return null;}
        $reflection = new \ReflectionClass(ApiResponseCodes::class);
        $constants = $reflection->getConstants();

        foreach ($constants as $name => $constantValue) {
            if ($constantValue === $value) {
                return $name;
            }
        }

        return null;
    }
}

?>