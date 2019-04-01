<?php

namespace Model;

use Entity\Email;
use Kdyby;
use Kdyby\Doctrine\EntityManager;
use Model\base\BaseService;
use Nette;
use Nette\Utils\Validators;

class Emails extends BaseService
{

	public function __construct(EntityManager $em)
	{
        parent::__construct($em, $em->getRepository(Email::class));
	}

	public function subscribe($email, $name=null)
	{
		if(!Validators::isEmail($email))
		{
			return false;
		}

		$subscribption = new Email;
		$subscribption->email = $email;
		$subscribption->name = $name;

		$this->save($subscribption);
		return true;
	}
}
