<?php

namespace AdminModule\Presenters;

use Components\EntityForm;
use Model\Reservations;

class ReservationsPresenter extends AdminPresenter
{

	/** @var Reservations @inject */
	public $reservations;

	public function startup()
	{
		parent::startup();
	}

	/////////////// Actions & renders

	public function renderDefault()
	{
		$this->template->reservations = $this->reservations->findBy(array(),array('date' => 'DESC'));

	}


	public function actionEdit($id = null)
	{

	}

	public function actionMySettings()
	{
		$this->redirect('edit', $this->reservations->id);
	}


	/////////////// Signals

	public function handleDelete($id)
	{
		$this->reservations->delete($this->reservations->find($id));

		$this->flashMessage($this->flash->ok);
		$this->redirect('this');
	}


	/////////////// Other


}