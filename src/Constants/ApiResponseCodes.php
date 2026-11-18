<?php

namespace FameSystems\ResellerAPI\Constants;

abstract class ApiResponseCodes
{
    // 100: Informational Codes
    public const CONTINUE = 10001;
    public const NO_CHANGE = 10002;
    public const READ_ONLY_PERFORMED = 10003;
    public const DEFAULT_VALUES_APPLIED = 10004;
    public const OPERATION_QUEUE_STARTED = 10005;

    // 200: Success Codes
    public const OK = 20001;
    public const UPDATED = 20002;
    public const DELETED = 20003;

    // 201: Created Codes
    public const CREATED = 20101;


    // 400: Bad Request Codes
    public const BAD_REQUEST = 40001;               // Generic bad request
    public const VALIDATION_ERROR = 40002;          // Validation-specific error
    public const MISSING_REQUIRED_FIELD = 40003;    // Missing fields in the request
    public const INVALID_FORMAT = 40004;            // Invalid format for a parameter
    public const INSUFFICIENT_FUNDS = 40005;        // Insufficient funds for the operation
    public const IPV6_NOT_SUPPORTED = 40006;        // Only possible for IPv4 (IP networks)

    // 401: Unauthorized Codes
    public const MISSING_TOKEN = 40101;
    public const INVALID_TOKEN = 40102;
    public const USER_NOT_FOUND = 40103;

    // 403: Forbidden Codes
    public const INSUFFICIENT_PERMISSIONS = 40301;
    public const ACCESS_DENIED = 40302;

    // 404: Not Found Codes
    public const NOT_FOUND = 40401;                 // Generic not found
    public const RESOURCE_NOT_FOUND = 40402;        // Specific resource not found
    public const PRODUCT_NOT_FOUND = 40403;         // Product not found, not yours or ended

    // 405: Method Not Allowed Codes
    public const METHOD_NOT_ALLOWED = 40501;

    // 429: Too Many Requests Codes
    public const TOO_MANY_REQUESTS = 42901;
    public const COOLDOWN_ACTIVE = 42902;           // Action on cooldown, see data->retryAfter
    public const RATE_LIMIT_EXCEEDED = 42903;       // Hourly limit reached, see data->retryAfter

    // 500: Internal Server Error Codes
    public const INTERNAL_SERVER_ERROR = 50001;
    public const DATABASE_ERROR = 50002;
    public const CACHE_ERROR = 50003;
    public const DEPENDENCY_ERROR = 50004;
    public const UNHANDLED_EXCEPTION = 50005;
    public const CONFIGURATION_ERROR = 50006;
    public const SERVICE_UNAVAILABLE = 50007;
    public const TIMEOUT = 50008;
    public const MEMORY_ERROR = 50009;

    // 530: Security Related Codes
    public const SECURITY_ERROR = 53001;
    public const SECURITY_VIOLATION = 53002;
}
