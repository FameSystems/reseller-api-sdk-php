<?php

namespace FameSystems\ResellerAPI\Models\ApiResponse\MusicBot;

class musicBotUserUsage {
    public int $storage;
    public int $bots;
    public int $usedStorage;
    public int $usedBots;
    public float $usedStoragePercentage;
    public float $usedBotsPercentage;

    public function __construct($musicBotUserUsageData)
    {
        $this->storage = $musicBotUserUsageData->storage ?? 0;
        $this->bots = $musicBotUserUsageData->bots ?? 0;
        $this->usedStorage = $musicBotUserUsageData->storage_used ?? 0;
        $this->usedBots = $musicBotUserUsageData->bots_used ?? 0;
        $this->usedStoragePercentage = $musicBotUserUsageData->storage_used_percent ?? 0;
        $this->usedBotsPercentage = $musicBotUserUsageData->bots_used_percent ?? 0;
    }

}

?>