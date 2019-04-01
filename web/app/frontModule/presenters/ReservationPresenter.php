<?php

namespace FrontModule\Presenters;

use App\Model;
use Entity\Reservation;
use FrontModule\Presenters\FrontPresenter;
use Model\Reservations;
use Nette;


class ReservationPresenter extends FrontPresenter
{

    /** @var Reservations @inject */
    public $games;

    public function startup()
    {
        parent::startup();
    }

    public function actionReservation()
    {
        $this->setView('game');
        $this->template->title = "RPG na programu";
        $this->template->games = $this->games->findBy(['processed' => 0], ['name' => 'ASC']);
    }

}
