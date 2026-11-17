<?php

namespace FameSystems\ResellerAPI;


use FameSystems\ResellerAPI\Models\ApiResponse;
use FameSystems\ResellerAPI\Models\Error;
use FameSystems\ResellerAPI\Models\Messages;


class Client implements ApiClientInterface
{
    public const DEFAULT_API_URL = 'https://v2.resellerapi.de/';
    public const DEFAULT_USER_AGENT = 'FameSystems Reseller SDK';

    private $token = null;
    private $userAgent = self::DEFAULT_USER_AGENT;
    private $apiUrl = self::DEFAULT_API_URL;
    private $CURLOPT_SSL_VERIFYPEER = true;
    private $CURLOPT_TIMEOUT = 30;

    /** Optional: Hash des aufrufenden Moduls (z. B. WHMCS-Modul), als Header "Module-Route". */
    private ?string $moduleRoute = null;

    public function __construct($token, $apiUrl = null, $userAgent = null)
    {
        $this->token = $token;

        if (!(is_null($apiUrl))) {
            $this->apiUrl = $apiUrl;
        }
        if (!(is_null($userAgent))) {
            $this->userAgent = $userAgent;
        }
    }

    /** Setzt den Header "Module-Route", damit Module das SDK nicht mehr selbst patchen müssen. */
    public function setModuleRoute(?string $moduleRoute): self
    {
        $this->moduleRoute = $moduleRoute;

        return $this;
    }

    public function setTimeout(int $seconds): self
    {
        $this->CURLOPT_TIMEOUT = max(1, $seconds);

        return $this;
    }

    public function get($url, $params = [])
    {
        return $this->request($url, $params, 'GET');
    }

    public function post($url, $params = [])
    {
        return $this->request($url, $params, 'POST');
    }

    public function delete($url, $params = [])
    {
        return $this->request($url, $params, 'DELETE');
    }

    public function put($url, $params = [])
    {
        return $this->request($url, $params, 'PUT');
    }

    private function request($url, $parameters, $method)
    {
        $url = rtrim($this->apiUrl, '/') . '/' . ltrim($url, '/');

        $curlRequest = curl_init($url);

        $headers = array(
            'Api-Token: ' . $this->token,
            'User-Agent: ' . $this->userAgent,
            'Content-Type: application/x-www-form-urlencoded',
            'accept: application/json'
        );
        if ($this->moduleRoute !== null && $this->moduleRoute !== '') {
            $headers[] = 'Module-Route: ' . $this->moduleRoute;
        }
        curl_setopt($curlRequest, CURLOPT_HTTPHEADER, $headers);

        if ($method == 'GET') {
            if (!empty($parameters)) {
                $url .= (strpos($url, '?') === false ? '?' : '&') . http_build_query($parameters);
                curl_setopt($curlRequest, CURLOPT_URL, $url);
            }
        } else {
            curl_setopt($curlRequest, CURLOPT_POSTFIELDS, http_build_query($parameters));
        }


        curl_setopt($curlRequest, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($curlRequest, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curlRequest, CURLOPT_SSL_VERIFYPEER, $this->CURLOPT_SSL_VERIFYPEER);
        curl_setopt($curlRequest, CURLOPT_USERAGENT, $this->userAgent);
        curl_setopt($curlRequest, CURLOPT_TIMEOUT, $this->CURLOPT_TIMEOUT);

        $data = curl_exec($curlRequest);
        if ($data === false || $data === '') {
            $error = curl_error($curlRequest);
            curl_close($curlRequest);

            return self::errorResponse('Connection to the Reseller API failed: ' . ($error !== '' ? $error : 'empty response'));
        }

        curl_close($curlRequest);


        $responseObj = json_decode($data);
        if (!is_object($responseObj) || !isset($responseObj->status)) {
            return self::errorResponse('The Reseller API returned an invalid response.');
        }

        // Set error code from the response (if available)
        $errorCode = 0;
        $errorMessage = '';
        if (isset($responseObj->messages->errors)) {
            if (is_countable($responseObj->messages->errors) && count($responseObj->messages->errors) > 0) {
                $errorCode = $responseObj->messages->errors[0]->code;  // Hier nehmen wir den ersten Fehlercode
                $errorMessage = $responseObj->messages->errors[0]->message;  // Hier nehmen wir die erste Fehlermeldung
            } elseif (isset($responseObj->messages->errors->code)) {
                $errorCode = $responseObj->messages->errors->code;
                $errorMessage = $responseObj->messages->errors->message;
            }
        }

        // Conversion of stdClass to Messages instance; jeder Fehler mit eigenem Code und Text.
        $errors = [];
        foreach ((array)($responseObj->messages->errors ?? []) as $error) {
            if (is_object($error) && isset($error->code)) {
                $errors[] = new Error((int)$error->code, (string)($error->message ?? ''));
            }
        }
        if ($errors === [] && $errorCode) {
            $errors[] = new Error((int)$errorCode, (string)$errorMessage);
        }

        $messages = new Messages(
            $errors,
            $responseObj->messages->warnings ?? [],
            $responseObj->messages->infos ?? [],
            $responseObj->messages->success ?? []
        );

        $requestId = $responseObj->requestId ?? 0;
        if ($requestId == null || is_numeric($requestId) == false) {
            $requestId = 0;
        }


        return new ApiResponse(
            (int)$requestId,
            (string)$responseObj->status,
            $responseObj->data ?? null,
            $messages,  // Transfer of the message instance
            (int)$errorCode  // Set error code in the FameSystems ApiResponse
        );
    }

    /** Fehlerantwort im üblichen Format, z. B. wenn die API nicht erreichbar ist. */
    private static function errorResponse(string $message): ApiResponse
    {
        return new ApiResponse(0, 'error', null, new Messages([new Error(0, $message)], [], [], []), 0);
    }

    // Helper method to ensure that the data is transferred as an array
    private static function convertToArray($data)
    {
        // Wenn die Daten ein stdClass-Objekt sind, in ein Array umwandeln
        return is_array($data) ? $data : (array)$data;
    }

    private function convertMessagesToInstance($messagesData)
    {
        if ($messagesData instanceof Messages) {
            return $messagesData;  // If there is already a 'Messages' instance, return it
        }

        // Otherwise, create a new 'Messages' instance with the correct data
        return new Messages(
            self::convertToArray($messagesData->errors),
            self::convertToArray($messagesData->warnings),
            self::convertToArray($messagesData->infos),
            self::convertToArray($messagesData->success)
        );
    }

}
