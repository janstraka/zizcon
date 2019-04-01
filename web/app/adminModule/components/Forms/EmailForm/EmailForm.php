<?php

namespace AdminModule\Components;

use Components\EntityForm;
use Entity\Email;
use Model\Contents;
use Model\Emails;
use Presenters\BasePresenter;
use Nette;
use Nette\Application\UI;
use Nette\Application\UI\Form;


class EmailForm extends UI\Control
{
    /** @var Emails */
    private $emails;

	public $onSave = [];



	public function __construct(Emails $emails)
	{
		parent::__construct();
		$this->emails = $emails;
	}

	public function render()
	{
		$this->template->setFile(__DIR__ . '/EmailForm.latte');
		$this->template->render();
	}

    public function setId($id)
    {
		$form = $this['emailForm'];
		$form->bindEntity($this->emails->find($id));
	}

    protected function createComponentEmailForm()
	{
		$form = new EntityForm;
		$form->setEntityService($this->emails);
		$form->bindEntity(new Email);

        $form->addText('email', 'zadejte email pro odběr menu')
            ->addRule(Form::EMAIL, 'Not valid email');


		$form->addSubmit('save', 'Uložit');
		$form->onSuccess[] = $this->processEmailForm;
		return $form;
	}


	public function processEmailForm(EntityForm $form, $values)
	{
		$form->handler($values);

		$this->onSave($this);
	}





}

interface IEmailFormFactory
{
	/** @return EmailForm */
	function create();
}

