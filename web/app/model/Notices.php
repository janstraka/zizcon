<?php

namespace Model;

use Entity\Notice;
use Kdyby;
use Kdyby\Doctrine\EntityManager;
use Model\base\BaseService;
use Nette;

class Notices extends BaseService
{

	/**
	 * Notices constructor.
	 * @param EntityManager $em
	 */
	public function __construct(EntityManager $em)
	{
		parent::__construct($em, $em->getRepository(Notice::class));
	}
	
	/**
	 * @param $limit
	 * @return mixed
	 */
	public function findAllASC($limit)
	{
		//return $this->findBy(array(), array('date' => 'DESC'));
		return $this->findBy(array(), array('date' => 'DESC'), $limit, 0);
	}

	public function findCount($count)
	{

	}
}