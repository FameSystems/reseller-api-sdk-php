<?php

namespace FameSystems\ResellerAPI\Models\ApiResponse\MusicBot;

use FameSystems\ResellerAPI\Models\ApiResponse;
use FameSystems\ResellerAPI\Models\ApiResponse\MusicBot\musicBotUserUsage;

class getMusicBotUserUsageApiResponse extends ApiResponse {
    public musicBotUserUsage $musicBotUserUsage;

    public function __construct($requestId, $status,$data, $messages, ?int $errorCode = null) {
        parent::__construct($requestId, $status, $data, $messages, $errorCode);

        $this->musicBotUserUsage = new musicBotUserUsage($data);
    }
}


?>