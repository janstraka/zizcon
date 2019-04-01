<?php

namespace AdminModule\Presenters;

use AdminModule\Components\IProgramFormFactory;
use AdminModule\Components\ProgramForm;
use Components\EntityForm;
use Model\Days;
use Model\Events;

class ProgramPresenter extends AdminPresenter
{

	/** @var Events @inject */
	public $events;

	/** @var Days @inject */
	public $days;

	/** @var IProgramFormFactory @inject */
	public $program_form_factory;


	public function startup()
	{
		parent::startup();
	}

	/////////////// Actions & renders

	public function renderDefault()
	{
		$this->template->days = $this->days->findAll();
	}


	public function actionEdit($id = null)
	{

	}

	public function actionMySettings()
	{
//		$this->redirect('edit', $this->notices->id);
	}


	/////////////// Signals

	public function handleDelete($id)
	{
		/*$this->notices->delete($this->notices->find($id));

		$this->flashMessage($this->flash->ok);
		$this->redirect('this');*/
	}


	/////////////// Components

	public function createComponentProgramForm()
	{
		$program_form = $this->program_form_factory->create();

		if ($id = $this->getParameter('id')) {
			$program_form->setId($id);
		}

		$program_form->onSave[] = function (ProgramForm $form) {
			$this->flashMessage($this->flash->ok);
			$this->redirect('default');
		};

		return $program_form;
	}


	/////////////// Other


}