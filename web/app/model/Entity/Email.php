<?php

namespace Entity;

use App;
use Doctrine\ORM\Mapping as ORM;
use Kdyby\Doctrine;

/**
 * @ORM\Entity
 * @ORM\Table(name="emails")
 */
class Email extends Doctrine\Entities\BaseEntity
{
	use Doctrine\Entities\Attributes\Identifier;

    /** @ORM\Column(unique=TRUE, type="string", length=100 ) */
    public $email;

    /** @ORM\Column(unique=TRUE, type="string", length=100, nullable=true) */
    public $name;





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





}
