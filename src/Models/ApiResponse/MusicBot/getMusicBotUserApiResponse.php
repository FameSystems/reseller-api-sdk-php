<?php

namespace FameSystems\ResellerAPI\Models\ApiResponse\MusicBot;

use FameSystems\ResellerAPI\Models\ApiResponse;
use FameSystems\ResellerAPI\Models\ApiResponse\MusicBot\musicBotUser;

class getMusicBotUserApiResponse extends ApiResponse {
    public musicBotUser $musicBotUser;

    public function __construct($requestId, $status,$data, $messages, ?int $errorCode = null) {
        parent::__construct($requestId, $status, $data, $messages, $errorCode);

        $this->musicBotUser = new musicBotUser($data);
    }
}


?>