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

    public function imageVerification(UploadedFile $file): bool
    {
        $extension = $file->guessExtension();
        if ($extension !== "jpg" && $extension !== "png" && $extension !== "jpeg") {
            return false;
        }
        return true;
    }
}
