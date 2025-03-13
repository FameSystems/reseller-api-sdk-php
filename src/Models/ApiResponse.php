<?php

namespace FameSystems\ResellerAPI\Models;

class ApiResponse {
    public int $requestId;
    public string $status;
    public $data;
    public Messages $messages;
    public ?int $errorCode = null;
    public string|null $errorConstantName = null;

    public function __construct(int $requestId, string $status,$data, $messages,?int $errorCode = null) {
        $this->requestId = $requestId;
        $this->status = $status;
        $this->data = $data;

        if($messages instanceof Messages) {
            $this->messages = $messages;
        }else{
            $this->messages = new Messages([],[],[],[]);
        }

        $this->errorCode = $errorCode;
        $this->errorConstantName = ErrorCodeResolver::getConstantName($errorCode);
    }

    // Optional: Getter-Methoden, falls gewünscht
    public function getRequestId(): int {
        return $this->requestId;
    }

    public function getStatus(): string {
        return $this->status;
    }

    public function getData(){
        return $this->data;
    }

    public function getMessages(): Messages {
        return $this->messages;
    }

    public function getErrorCode(): ?int {
        return $this->errorCode;
    }
}

?>