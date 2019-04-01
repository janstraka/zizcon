<?php

//namespace Entity;
namespace App\Model\Entity;

use Doctrine\ORM\Mapping as ORM;
use Kdyby\Doctrine\Entities\BaseEntity;
use Kdyby\Doctrine;

/**
 * @ORM\Entity
 * @ORM\Table(name="reservations")
 */
class Reservation extends BaseEntity
{

	use Doctrine\Entities\Attributes\Identifier;

	/**
	 * @ORM\Column(type="string", length=100)
	 */
	private $name;

	/**
	 * @return mixed
	 */
	public function getQuantity()
	{
		return $this->quantity;
	}

	/**
	 * @param mixed $quantity
	 */
	public function setQuantity($quantity)
	{
		$this->quantity = $quantity;
	}

	/**
	 * @ORM\Column(type="string", length=100)
	 */
	private $surname;

	/**
	 * @ORM\Column(type="string", length=100)
	 */
	private $email;

	/**
	 * @ORM\Column(type="string", length=100)
	 */
	private $phone;

	/**
	 * @ORM\Column(type="integer", length=3)
	 */
	private $price;

	/**
	 * @ORM\Column(type="integer", length=3)
	 */
	private $quantity;

	/**
	 * @ORM\Column(type="datetime")
	 */
	private $date;

	/**
	 * @return mixed
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * @param mixed $name
	 */
	public function setName($name)
	{
		$this->name = $name;
	}

	/**
	 * @return mixed
	 */
	public function getSurname()
	{
		return $this->surname;
	}

	/**
	 * @param mixed $surname
	 */
	public function setSurname($surname)
	{
		$this->surname = $surname;
	}

	/**
	 * @return mixed
	 */
	public function getEmail()
	{
		return $this->email;
	}

	/**
	 * @param mixed $email
	 */
	public function setEmail($email)
	{
		$this->email = $email;
	}

	/**
	 * @return mixed
	 */
	public function getPhone()
	{
		return $this->phone;
	}

	/**
	 * @param mixed $phone
	 */
	public function setPhone($phone)
	{
		$this->phone = $phone;
	}

	/**
	 * @return mixed
	 */
	public function getPrice()
	{
		return $this->price;
	}

	/**
	 * @param mixed $price
	 */
	public function setPrice($price)
	{
		$this->price = $price;
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

	/**
	 * @param mixed $date
	 */
	public function getFullPrice()
	{
		return $this->quantity * $this->price;
	}


}