<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class ImageVerification
{
    public array $errors;

    public function __construct()
    {
        $this->errors = [];
    }

    public function imageVerification(UploadedFile $file): void
    {
        $extension = $file->guessExtension();
        if ($extension !== "jpg") {
            $this->errors[] = "Veuillez utilisez une image au Format PNG, JPG ou JPEG";
        }
    }
}
