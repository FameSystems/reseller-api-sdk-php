<?php

namespace FameSystems\ResellerAPI\Models\ApiResponse\MusicBot;

use DateTime;

class musicBotUser {
    public int $id;
    public string $username;
    public string $email;
    public int $storage;
    public int $bots;
    public bool $enabled;
    public DateTime $updated;
    public DateTime $created;


    public function __construct($musicBotUserData)
    {
        $this->id = $musicBotUserData->id ?? 0;
        $this->username = $musicBotUserData->username ?? '';
        $this->email = $musicBotUserData->email ?? '';
        $this->storage = $musicBotUserData->storage ?? 0;
        $this->bots = $musicBotUserData->bots ?? 0;
        $this->enabled = boolval($musicBotUserData->enabled) ?? false;
        $this->updated = new DateTime(date("Y-m-d H:i:s", strtotime($musicBotUserData->updated))) ?? new DateTime();
        $this->created = new DateTime(date("Y-m-d H:i:s", strtotime($musicBotUserData->created))) ?? new DateTime();
    }

}


?>