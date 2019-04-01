<?php

namespace FrontModule\Presenters;


use App\Model;
use DateTime;
use FrontModule\Presenters\FrontPresenter;
use Nette;
use Nette\Application\UI\Form;



class RulesPresenter extends FrontPresenter
{

	public function startup()
	{
		parent::startup();
		$this->template->title = "Pravidla účasti";
	}

	public function actionDefault()
	{

	}

}
