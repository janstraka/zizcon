<?php

namespace Entity;

use Doctrine\ORM\Mapping as ORM;
use Kdyby\Doctrine;
use Nette\Security\Passwords;

/**
 * @ORM\Entity
 * @ORM\Table(name="games")
 *
 */
class Game extends Doctrine\Entities\BaseEntity
{
    const GAME_BOARD = 'board',
        GAME_RPG = 'rpg',
        GAME_LARP = 'larp',
        GAME_TOUR = 'tournament',
        GAME_PRES = 'presentation',
        GAME_OTHER = 'other';

    use Doctrine\Entities\Attributes\Identifier;

    /** @ORM\Column(type="string", length=100) */
    protected $name;

    /** @ORM\Column(type="text") */
    protected $description;

    /** @ORM\Column(type="enum", columnDefinition="enum('board', 'rpg', 'larp') NOT NULL") */
    protected $game_type = self::GAME_BOARD;

}
