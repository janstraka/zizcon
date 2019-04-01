<?php

namespace Model;

use Entity\Game;
use Kdyby;
use Kdyby\Doctrine\EntityManager;
use Model\base\BaseService;
use Nette;

class Games extends BaseService
{

    public function __construct(EntityManager $em)
    {
        parent::__construct($em, $em->getRepository(Game::class));
    }

}
