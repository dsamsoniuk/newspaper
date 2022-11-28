<?php

namespace App\Service;

use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

class FileUploader
{
    const IMAGE_DIR = 'article_image/';
    
    private $publicDirectory;
    private $slugger;
    private $logger;

    public function __construct($publicDirectory, SluggerInterface $slugger, LoggerInterface $logger)
    {
        $this->publicDirectory = $publicDirectory;
        $this->slugger = $slugger;
        $this->logger = $logger;
    }

    public function upload(UploadedFile $file, $dir = '/'): ?string
    {
        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = $this->slugger->slug($originalFilename);
        $fileName = $safeFilename.'-'.uniqid().'.'.$file->guessExtension();

        try {
            $file->move($this->getPublicDirectory().$dir, $fileName);
        } catch (FileException $e) {
            $this->logger->alert($e->getMessage());
            return null;
        }

        return $fileName;
    }
    public function getPublicDirectory()
    {
        return $this->publicDirectory;
    }
}