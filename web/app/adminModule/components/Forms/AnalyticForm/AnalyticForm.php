<?php

namespace AdminModule\Components;

use Components\EntityForm;
use Entity\Analytic;
use Model\Analytics;
use Nette;
use Nette\Application\UI;

class AnalyticForm extends UI\Control
{
    /** @var Analytics */
    private $analytics;

    public $onSave = [];

	public function __construct(Analytics $analytics)
	{
		parent::__construct();
        $this->analytics = $analytics;
	}

	public function render()
	{
		$this->template->render(__DIR__ . '/analyticForm.latte');
	}

    public function setId($id)
    {
        $this['form']->bindEntity($this->analytics->find($id));
    }

    protected function createComponentForm()
	{
		$form = new EntityForm;

        $form->addFormFiller('form_filler', $this->getTestingFields()/*, $this->getName()*/);

		$form->setEntityService($this->analytics);
        $form->bindEntity(new Analytic);

		$form->addText('title', 'title');
        $form->addTextArea('text', 'text');
		$form->addSubmit('save', 'save');

		$form->onSuccess[] = $this->processForm;

		return $form;
	}

	public function processForm(EntityForm $form, $values)
	{
		$form->handler($values);

		$this->onSave($this);
	}

    private function getTestingFields(){
        return [
            'date' => 'date',
            'address' => 'text',
            'room' => 'text',
            'title' => 'text',
            'annotation' => 'text',
            'detail' => 'text',

        ];
    }


}

interface IAnalyticFormFactory
{
	/** @return AnalyticForm */
	function create();
}
