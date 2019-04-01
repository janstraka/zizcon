<?php

namespace Model;

use Entity\EmailLog;
use Kdyby;
use Kdyby\Doctrine\EntityManager;
use Model\base\BaseService;
use Nette;
use Nette\Utils\Validators;

class EmailLogs extends BaseService
{

	public function __construct(EntityManager $em)
	{
        parent::__construct($em, $em->getRepository(EmailLog::class));
	}

}
