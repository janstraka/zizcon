<?php

namespace Entity;

use Doctrine\ORM\Mapping as ORM;
use Kdyby\Doctrine\Entities\BaseEntity;
use Kdyby\Doctrine;

/**
 * @ORM\Entity
 * @ORM\Table(name="notices")
 */
class Notice extends BaseEntity
{

	use Doctrine\Entities\Attributes\Identifier;

	/**
	 * @ORM\Column(type="string", length=100)
	 */
	private $content;

	/**
	 * @ORM\Column(type="string", length=100)
	 */
	private $image;


	/**
	 * @ORM\Column(type="datetime")
	 */
	private $date;

	/**
	 * @return mixed
	 */
	public function getContent()
	{
		return $this->content;
	}

	/**
	 * @param mixed $content
	 */
	public function setContent($content)
	{
		$this->content = $content;
	}

	/**
	 * @return mixed
	 */
	public function getImage()
	{
		return $this->image;
	}

	/**
	 * @param mixed $image
	 */
	public function setImage($image)
	{
		$this->image = $image;
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