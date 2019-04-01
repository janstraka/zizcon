<?php

namespace AdminModule\Components;

use Components\EntityForm;
use Entity\EmailTemplate;
use Model\EmailTemplates;
use Nette;
use Nette\Application\UI;

class EmailTemplateForm extends UI\Control
{
    public $onSave = [];

    private $email_templates;

    public function __construct(EmailTemplates $email_templates)
	{
		parent::__construct();
        $this->email_templates = $email_templates;
    }

	public function render()
	{
		$this->template->render(__DIR__ . '/emailTemplateForm.latte');
	}

    public function setId($id = null)
    {
        $this['form']->bindEntity($this->email_templates->find($id));
    }

    protected function createComponentForm()
	{
		$form = new EntityForm;

        $form->addFormFiller('form_filler', $this->getTestingFields());

        $form->setEntityService($this->email_templates);
        $form->bindEntity(new EmailTemplate);


        //$form->addHidden('id');

        $form->addText('title', 'title');
        $form->addText('subject', 'subject');
        $form->addTextArea('content', 'content')
            ->getControlPrototype()->class[] = 'wysiwyg';


        $form->addSubmit('save', 'uložit');

		$form->onSuccess[] = $this->processForm;

		return $form;
	}

	public function processForm(EntityForm $form, $values)
	{
        unset($values['formFiller']);
        $form->handler($values);

        $this->onSave($this, $values);
	}

    private function getTestingFields(){
        return [
            'title' => 'text',
            'subject' => 'text',
            'content' => 'text',
        ];
    }


}

interface IEmailTemplateFormFactory
{
	/** @return EmailTemplateForm */
	function create();
}
