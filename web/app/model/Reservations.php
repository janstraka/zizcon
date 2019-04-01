<?php
namespace Model;

use App\Model\Entity\Reservation;

use Kdyby\Doctrine\EntityManager;
use Model\base\BaseService;

class Reservations extends BaseService
{
	/**
	 * @param EntityManager $em
	 */
	public function __construct(EntityManager $em)
	{
		parent::__construct($em, $em->getRepository(Reservation::class));
	}
	


}