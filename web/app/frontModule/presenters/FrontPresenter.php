<?php

namespace FrontModule\Presenters;

use BaseModule\Presenters\BasePresenter;
use FrontModule\Components\GameView;
use Model;
use Model\Notices;
use Nette;


abstract class FrontPresenter extends BasePresenter
{

    /** @var Notices @inject */
    public $notices;

    public function startup()
    {
        parent::startup();
        $this->template->notices = $this->notices->findAllASC(3);
    }

    public function createComponentGame()
    {
		return new GameView();
    }

}

