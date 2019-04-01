<?php

namespace FrontModule\Presenters;

use Nette;


class DefaultPresenter extends FrontPresenter
{

	public function actionDefault()
	{
		$this->template->sss = 'ahoj';
	}

}
