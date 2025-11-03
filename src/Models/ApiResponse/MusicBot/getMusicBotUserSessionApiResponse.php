<?php

namespace FameSystems\ResellerAPI\Models\ApiResponse\MusicBot;

use FameSystems\ResellerAPI\Models\ApiResponse;
use FameSystems\ResellerAPI\Models\ApiResponse\MusicBot\musicBotUserSession;


class getMusicBotUserSessionApiResponse extends ApiResponse {
    public musicBotUserSession $musicBotUserSession;

    public function __construct($requestId, $status,$data, $messages, ?int $errorCode = null) {
        parent::__construct($requestId, $status, $data, $messages, $errorCode);

        $this->musicBotUserSession = new musicBotUserSession($data);
    }
}

?>