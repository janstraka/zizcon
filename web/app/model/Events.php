<?php

namespace Model;

use Entity\Event;
use Kdyby;
use Kdyby\Doctrine\EntityManager;
use Model\base\BaseService;
use Nette;

class Events extends BaseService
{

	public function __construct(EntityManager $em)
	{
        parent::__construct($em, $em->getRepository(Event::class));
	}
	
}
