<?php
namespace FameSystems\ResellerAPI\Models;

class Messages {
    public array $errors;
    public array $warnings;
    public array $infos;
    public array $success;

    public function __construct($errors, $warnings, $infos, $success) {
        // Konvertiere stdClass-Objekte in Arrays, falls nötig
        $this->errors = is_array($errors) ? $errors : (array)$errors;
        $this->warnings = is_array($warnings) ? $warnings : (array)$warnings;
        $this->infos = is_array($infos) ? $infos : (array)$infos;
        $this->success = is_array($success) ? $success : (array)$success;
    }
}
?>