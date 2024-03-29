<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class UploadService
{
    private  string  $targetDirectory;
    public function __construct( string $target_dir)
    {
        $this->targetDirectory = $target_dir;
    }

    public function  upload(UploadedFile  $file): string
    {
        $destination = $this->targetDirectory.'/avatars';
        $originalName =pathinfo($file->getClientOriginalName(),PATHINFO_FILENAME);
        $newName = $originalName.'_'.uniqid().'.'.$file->guessExtension();
        $file->move($destination,$newName);
        return  $newName;
    }
}