<?php

namespace FrontModule\Presenters;

use App\Model;
use Entity\Game;
use FrontModule\Presenters\FrontPresenter;
use Model\Games;
use Nette;


class GamePresenter extends FrontPresenter
{

    /** @var Games @inject */
    public $games;

    public function startup()
    {
        parent::startup();
    }

    public function actionRPG()
    {
        $this->setView('game');
        $this->template->title = "RPG na programu";
        $this->template->games = $this->games->findBy(['game_type' => Game::GAME_RPG], ['name' => 'ASC']);
    }

    public function actionLarp()
    {
        $this->template->title = "LARP na programu";
        $this->template->games = $this->games->findBy(['game_type' => Game::GAME_LARP], ['name' => 'ASC']);
    }

    public function actionBoard()
    {
        $this->template->title = "Deskovky na programu";
        $this->template->games = $this->games->findBy(['game_type' => Game::GAME_BOARD], ['name' => 'ASC']);
    }

    public function actionTournament()
    {
        $this->template->title = "Turnaje na programu";
        $this->template->games = $this->games->findBy(['game_type' => Game::GAME_TOUR], ['name' => 'ASC']);
    }

    public function actionPresentation()
    {
        $this->template->title = "Přednášky na programu";
        $this->template->games = $this->games->findBy(['game_type' => Game::GAME_PRES], ['name' => 'ASC']);
    }

    public function actionOther()
    {
        $this->template->title = "Ostatní na programu";
        $this->template->games = $this->games->findBy(['game_type' => Game::GAME_OTHER], ['name' => 'ASC']);
    }

}
