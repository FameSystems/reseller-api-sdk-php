<?php

namespace FameSystems\ResellerAPI\Routes;

use FameSystems\ResellerAPI\Client;
use FameSystems\ResellerAPI\Models\ApiResponse;
use FameSystems\ResellerAPI\Models\ApiResponseMapper;

class Musicbot{

    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }


    public function getAccount(int $account_id) : ApiResponse\MusicBot\getMusicBotUserApiResponse{
        return ApiResponseMapper::mapResponseToModel($this->client->get("musicbot/user",[
            'id' => $account_id
        ]),
            'FameSystems\ResellerAPI\Models\ApiResponse\MusicBot\getMusicBotUserApiResponse');
    }

    public function createAccount(string $username,$email, string $password, int $storage, int $bots) : ApiResponse{
        return $this->client->post('musicbot/user/create', [
            'username' => $username,
            'email' => $email,
            'password' => $password,
            'storage' => $storage,
            'bots' => $bots
        ]);
    }

    public function deleteAccount(string $username) : ApiResponse{
        return $this->client->delete('musicbot/user/delete', [
            'username' => $username
        ]);
    }

    public function disableAccount(string $username) : ApiResponse{
        return $this->client->post('musicbot/user/disable', [
            'username' => $username
        ]);
    }

    public function enableAccount(string $username) : ApiResponse{
        return $this->client->post('musicbot/user/enable', [
            'username' => $username
        ]);
    }

    public function getAccountUsage(string $username) : ApiResponse\MusicBot\getMusicBotUserUsageApiResponse{
        return ApiResponseMapper::mapResponseToModel($this->client->get("musicbot/user/usage",[
            'username' => $username
        ]),
            'FameSystems\ResellerAPI\Models\ApiResponse\MusicBot\getMusicBotUserUsageApiResponse');
    }

    public function createAccountLoginSession(string $username) : ApiResponse\MusicBot\getMusicBotUserSessionApiResponse{
        return ApiResponseMapper::mapResponseToModel($this->client->post("musicbot/user/session/create",[
            'username' => $username
        ]),
            'FameSystems\ResellerAPI\Models\ApiResponse\MusicBot\getMusicBotUserSessionApiResponse');
    }

    public function deleteAccountLoginSession(string $username) : ApiResponse{
        return $this->client->delete('musicbot/user/session/delete', [
            'username' => $username
        ]);
    }

    public function setAccountPassword(string $username, string $newPassword) : ApiResponse{
        return $this->client->post('musicbot/user/set/password', [
            'username' => $username,
            'password' => $newPassword
        ]);
    }



}