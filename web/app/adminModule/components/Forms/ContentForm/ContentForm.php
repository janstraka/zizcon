<?php

namespace AdminModule\Components;

use Components\EntityForm;
use Entity\Content;
use Entity\Preview;
use Model\Contents;
use Nette;
use Nette\Application\UI;

class ContentForm extends UI\Control
{
    /** @var Contents */
    private $contents;

    public $onSave = [];

	public function __construct(Contents $contents)
	{
		parent::__construct();
        $this->contents = $contents;
	}

	public function render()
	{
		$this->template->render(__DIR__ . '/contentForm.latte');
	}

    public function setId($id = null)
    {
        if($id){
            $this['contentForm']->bindEntity($this->contents->find($id));
        }
    }

    protected function createComponentContentForm()
	{
		$form = new EntityForm;

		$form->setEntityService($this->contents);
        $form->bindEntity(new Content);

		$form->addText('title', 'nadpis');

        $form->addTextArea('text', 'text')
            ->getControlPrototype()->class[] = 'wysiwyg';
		$form->addSubmit('save', 'uložit');

		$form->onSuccess[] = $this->processContentForm;

		return $form;
	}

	public function processContentForm(EntityForm $form, $values)
	{
		$form->handler($values);

		$this->onSave($this);
	}



}

interface IContentFormFactory
{
	/** @return ContentForm */
	function create();
}
