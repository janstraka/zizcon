<?php

namespace AdminModule\Presenters;

use BaseModule\Presenters\BasePresenter;

class AdminPresenter extends BasePresenter
{
	/////////////////////// Public

	public function startup()
	{
		parent::startup();

		$this->isUserAllowedToAdmin();
	}


	/////////////////////// Private

	private function isUserAllowedToAdmin()
	{
		if ($this->getAction() != 'in' AND !$this->user->isInRole('admin')) {
			$this->flashMessage($this->flash->you_must_be_logged);
			$this->redirect(':Admin:Sign:in', ['backlink' => $this->storeRequest()]);
		}
	}

}