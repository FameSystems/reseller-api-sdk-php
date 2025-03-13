<?php
namespace FameSystems\ResellerAPI\Models;

class ApiResponseMapper {

    public static function mapResponseToModel(ApiResponse $response, string $modelClassName) {
        /** @var ApiResponse $response */

        // Check whether the specified class exists
        if (!class_exists($modelClassName)) {
            throw new \Exception("The $modelClassName class does not exist.");
        }

        // Check whether the class is a subtype of ApiResponse
        $reflection = new \ReflectionClass($modelClassName);
        if (!$reflection->isSubclassOf(ApiResponse::class)) {
            throw new \Exception("$modelClassName must inherit from ApiResponse.");
        }

        // Umwandlung von stdClass zu Messages, falls notwendig
        $messages = self::convertMessagesToInstance($response->messages);

        // Dynamisch das Modell erstellen und die Antwort an das Modell übergeben
        return new $modelClassName(
            $response->requestId,
            $response->status,
            $response->data,
            $messages,  // Übergabe der Messages-Instanz
            $response->errorCode
        );
    }

    // Methode zur Umwandlung von stdClass zu Messages
    private static function convertMessagesToInstance($messagesData) {
        if ($messagesData instanceof Messages) {
            return $messagesData;  // Wenn bereits eine Instanz von Messages, einfach zurückgeben
        }

        // Andernfalls eine neue Instanz von Messages erstellen
        return new Messages(
            self::convertToArray($messagesData->errors),
            self::convertToArray($messagesData->warnings),
            self::convertToArray($messagesData->infos),
            self::convertToArray($messagesData->success)
        );
    }

    // Hilfsmethode zur Umwandlung von stdClass-Objekten zu Arrays
    private static function convertToArray($data) {
        return is_array($data) ? $data : (array)$data;
    }
}
?>