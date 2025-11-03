<?php

namespace FameSystems\ResellerAPI\Models\ApiResponse\MusicBot;

class  musicBotUserSession{
    public string $sessionId;
    public string $loginUrl;
    public string $panelUrl;

    public function __construct($musicBotUserSessionData)
    {
        $this->sessionId = $musicBotUserSessionData->login_session ?? "";
        $this->loginUrl = $musicBotUserSessionData->login_url ?? "";
        $this->panelUrl = $musicBotUserSessionData->panel_url ?? "";
    }
}


?>