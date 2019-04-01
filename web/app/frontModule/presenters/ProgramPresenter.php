<?php

namespace FrontModule\Presenters;

use App\Model;
use FrontModule\Presenters\FrontPresenter;
use Nette;


class ProgramPresenter extends FrontPresenter
{
	public function startup()
	{
		parent::startup();
		$this->template->title = "Program";
	}

}
