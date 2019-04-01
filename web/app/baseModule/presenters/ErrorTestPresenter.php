<?php

namespace BaseModule\Presenters;

use Nette;

class ErrorTestPresenter extends BasePresenter
{
    public function actionE500()
    {
        $this->setView('../Error/500');
	}

    public function actionE404()
    {
        $this->setView('../Error/404');
    }
}
