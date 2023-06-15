<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class ImageFileVerification
{
    public array $errors;

    public function __construct()
    {
        $this->errors = [];
    }

    public function imageVerification(UploadedFile $file)
    {
        $extension = $file->guessExtension();
        if ($extension !== "jpg") {
            $this->errors[] = "Veuillez utilisez une image au Format PNG, JPG ou JPEG";
        }
    }
}
