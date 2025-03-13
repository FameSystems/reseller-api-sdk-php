<?php

namespace FameSystems\ResellerAPI;


use FameSystems\ResellerAPI\Models\ApiResponse;
use FameSystems\ResellerAPI\Models\Error;
use FameSystems\ResellerAPI\Models\Messages;


class Client implements ApiClientInterface
{

    private $token = null;
    private $userAgent = 'FameSystems Reseller SDK';
    private $apiUrl = 'https://dev-api.famesystems.de/';
    private $CURLOPT_SSL_VERIFYPEER = false;
    private $CURLOPT_TIMEOUT = 30;

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
        $url = $this->apiUrl . $url;

        $curlRequest = curl_init($url);


        curl_setopt($curlRequest, CURLOPT_HTTPHEADER, array(
            'Api-Token: ' . $this->token,
            'User-Agent: ' . $this->userAgent,
            'Content-Type: application/x-www-form-urlencoded',
            'accept: application/json'
        ));

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

        if (!$data = curl_exec($curlRequest)) {
            $error = curl_error($curlRequest);
            return ['error' => $error];
        }

        curl_close($curlRequest);


        $responseObj = json_decode($data);

        // Set error code from the response (if available)
        $errorCode = 0;
        $errorMessage = '';
        if (isset($responseObj->messages->errors)) {
            if (is_countable($responseObj->messages->errors) && count($responseObj->messages->errors) > 0) {
                $errorCode = $responseObj->messages->errors[0]->code;  // Hier nehmen wir den ersten Fehlercode
                $errorMessage = $responseObj->messages->errors[0]->message;  // Hier nehmen wir die erste Fehlermeldung
            } else {
                $errorCode = $responseObj->messages->errors->code;
                $errorMessage = $responseObj->messages->errors->message;
            }

        }


        // Conversion of stdClass to Messages instance
        $messages = new Messages(
            array_map(fn($error) => new Error($errorCode, $errorMessage), (array)$responseObj->messages->errors ?? []),
            $responseObj->messages->warnings ?? [],
            $responseObj->messages->infos ?? [],
            $responseObj->messages->success ?? []
        );

        $requestId = $responseObj->requestId;
        if($requestId == null || is_numeric($requestId) == false){$requestId = 0;}


        return new ApiResponse(
            $requestId,
            $responseObj->status,
            $responseObj->data,
            $messages,  // Transfer of the message instance
            $errorCode  // Set error code in the FameSystems ApiResponse
        );
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


?>




