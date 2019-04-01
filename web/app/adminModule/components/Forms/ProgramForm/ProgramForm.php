<?php

namespace AdminModule\Components;

use Components\EntityForm;
use DateTime;
use Entity\Event;
use Model\Days;
use Model\Events;
use Nette;
use Nette\Application\UI;
use Nette\Application\UI\Form;

class ProgramForm extends UI\Control
{
	/** @var days */
	private $days;

	/** @var events */
	private $events;

	public $onSave = [];

	public function __construct(Days $days, Events $events)
	{
		parent::__construct();
		$this->days = $days;
		$this->events = $events;
	}

	public function render()
	{
		$this->template->render(__DIR__ . '/programForm.latte');
	}

	public function setId($id)
	{
		/** @var EntityForm $form */
		$form = $this['programForm'];

		$form->bindEntity($this->events->find($id));
		//$form['password']->setRequired(FALSE);
	}

	protected function createComponentProgramForm()
	{
		$form = new EntityForm;
		$form->setEntityService($this->events);
		$form->bindEntity(new Event);

		$form->addTextArea('title', 'Název')->setRequired();
		$form->addText('date_start', 'Začátek akce')->setRequired();
		$form->addText('date_end', 'Konec akce')->setRequired();

		$form->addSubmit('save', 'uložit');
		$form->onSuccess[] = $this->processProgramForm;
		return $form;
	}


	public function processProgramForm(EntityForm $form, $values)
	{
		// if editing, password is not required
		/*if (!$values->password) {
			unset($values->password);
		}
*/
		/*if ($values->photo->isOk()) {
			$image = $this->image_storage->upload($values->photo);
			$values->photo = $image;
		} else {
			unset($values->photo);
		}*/
		if(!isset($values->image)){
			$values->image = "obrazek.jpg";
		}
		$values->date = new DateTime();
		$form->handler($values);

		$this->onSave($this);
	}

}

interface IProgramFormFactory
{
	/** @return ProgramForm */
	function create();
}



