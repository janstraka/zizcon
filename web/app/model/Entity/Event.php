<?php

namespace Entity;

use Doctrine\ORM\Mapping as ORM;
use Kdyby\Doctrine\Entities\BaseEntity;
use Kdyby\Doctrine;

/**
 * @ORM\Entity
 * @ORM\Table(name="events")
 */
class Event extends BaseEntity
{

	use Doctrine\Entities\Attributes\Identifier;

	/**
	 * @ORM\Column(type="string", length=100)
	 */
	private $title;

	/**
	 * @ORM\ManyToOne(targetEntity="Day", inversedBy="event")
	 * @ORM\JoinColumn(name="id_day", referencedColumnName="id")
	 */
	private $id_day;

	/**
	 * @ORM\Column(type="datetime")
	 */
	private $date_start;

	/**
	 * @ORM\Column(type="datetime")
	 */
	private $date_end;


}