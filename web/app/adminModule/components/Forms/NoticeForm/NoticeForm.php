<?php

namespace AdminModule\Components;

use Components\EntityForm;
use DateTime;
use Entity\Notice;
use Model\Notices;
use Nette;
use Nette\Application\UI;
use Nette\Application\UI\Form;

class NoticeForm extends UI\Control
{
	/** @var Notices */
	private $notices;

	public $onSave = [];

	public function __construct(Notices $notices)
	{
		parent::__construct();
		$this->notices = $notices;
	}

	public function render()
	{
		$this->template->render(__DIR__ . '/noticeForm.latte');
	}

	public function setId($id)
	{
		/** @var EntityForm $form */
		$form = $this['noticeForm'];

		$form->bindEntity($this->notices->find($id));
		//$form['password']->setRequired(FALSE);
	}

	protected function createComponentNoticeForm()
	{
		$form = new EntityForm;
		$form->setEntityService($this->notices);
		$form->bindEntity(new Notice);


		$form->addTextArea('content', 'Obsah')->setRequired();

		$form->addFormFiller('form_filler', $this->getTestingFields());
		
		$form->addSubmit('save', 'uložit');
		$form->onSuccess[] = $this->processNoticeForm;
		return $form;
	}


	public function processNoticeForm(EntityForm $form, $values)
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

interface INoticeFormFactory
{
	/** @return NoticeForm */
	function create();
}



