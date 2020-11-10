<?php

namespace App\Model;

use Nette;

class SponsorManager
{
    use Nette\SmartObject;

    /** @var Nette\Database\Context */
    private $database;

    public function __construct(Nette\Database\Context $database)
    {
        $this->database = $database;
    }

    public function getActiveSponsors()
    {
        return $this->database->table('sponsors')
            ->whereOr(['is_main_sponsor' => true, 'is_minor_sponsor' => true])
            ->order('created_at ASC');
        
    }
}