<?php 

namespace App\Services;

use Encore\Admin\Form\Field\Image;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ImageService extends Image
{
    protected function generateSequenceName(UploadedFile $file)
    {
        return generateImageName($file);
    }
}