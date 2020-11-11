<?php

namespace App\Model;

use Nette;

class GalleryManager
{
    use Nette\SmartObject;

    /** @var Nette\Database\Context */
    private $database;

    public function __construct(Nette\Database\Context $database)
    {
        $this->database = $database;
    }

    public function getGalleryPictures()
    {
        return $this->database->table('gallery')
            ->order('created_at ASC');
        
    }
}