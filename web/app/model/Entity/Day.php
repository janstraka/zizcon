<?php

namespace Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Kdyby\Doctrine\Entities\BaseEntity;
use Kdyby\Doctrine;

/**
 * @ORM\Entity
 * @ORM\Table(name="days")
 */
class Day extends BaseEntity
{

	/**
	 * Day constructor.
	 */
	public function __construct()
	{
		$this->event = new ArrayCollection();
	}

	use Doctrine\Entities\Attributes\Identifier;

	/**
	 * @ORM\OneToMany(targetEntity="Event", mappedBy="id")
	 */
	private $event;
	

	/**
	 * @ORM\Column(type="datetime")
	 */
	private $date;



	/**
	 * @return mixed
	 */
	public function getEvent()
	{
		return $this->event;
	}

	/**
	 * @param mixed $event
	 */
	public function setEvent($event)
	{
		$this->event = $event;
	}

	/**
	 * @return mixed
	 */
	public function getDate()
	{
		return $this->date;
	}

	/**
	 * @param mixed $date
	 */
	public function setDate($date)
	{
		$this->date = $date;
	}




}