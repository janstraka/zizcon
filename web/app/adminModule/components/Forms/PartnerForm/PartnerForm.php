<?php

namespace AdminModule\Components;

use DateTime;
use Entity\Partner;
use Model\Partners;
use Nette;
use Nette\Application\UI;
use Nette\Application\UI\Form;

class PartnerForm extends UI\Control
{
	/** @var Partners */
	private $partners;

	public $onSave = [];

	public function __construct(Partners $partners)
	{
		parent::__construct();
		$this->partners = $partners;
	}

	public function render()
	{
		$this->template->render(__DIR__ . '/partnerForm.latte');
	}

	public function setId($id)
	{
		$form = $this['partnerForm'];
		$form->bindEntity($this->partners->find($id));
	}

	protected function createComponentPartnerForm()
	{
		$form = new Form;
		$form->setEntityService($this->partners);
		$form->bindEntity(new Partner);


		$form->addTextArea('content', 'Obsah')->setRequired();

		$form->addFormFiller('form_filler', $this->getTestingFields());

		$form->addSubmit('save', 'uložit');
		$form->onSuccess[] = $this->processPartnerForm;
		return $form;
	}


	public function processPartnerForm(PartnerForm $form, $values)
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
		if (!isset($values->image)) {
			$values->image = "obrazek.jpg";
		}
		$values->date = new DateTime();
		$form->handler($values);
		$this->onSave($this);
	}

	private function getTestingFields()
	{
		return [
			'email' => 'email',
			'password' => 'text',
			'name' => 'text',
			'surname' => 'text',
			'phone' => 'phone',
		];
	}
}

interface IPartnerFormFactory
{
	/** @return PartnerForm */
	function create();
}



