<?php

namespace BaseModule\Components;

use Components\EntityForm;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Model\Customers;
use Nette;
use Nette\Application\UI;

class CustomerForm extends UI\Control
{
    /** @var Customers */
    private $customers;

    public $onSave = [];

	public function __construct(Customers $customers)
	{
		parent::__construct();
        $this->customers = $customers;
	}

	public function render()
	{
		$this->template->render(__DIR__ . '/customerForm.latte');
	}

    public function setId($id)
    {
		$form = $this['customerForm'];

		$form->bindEntity($this->customers->find($id));
		$form['password']->setRequired(FALSE);
    }

    public function setUsernameDisabled()
    {
        $this['customerForm']['username']->setDisabled(true);
    }

    protected function createComponentCustomerForm()
	{
		$form = new EntityForm;
		$form->setEntityService($this->customers);
        $form->bindEntity(new Customer);

		$form->addText('username', 'už. jméno');
		$form->addText('email', 'email');
		$form->addText('password', 'heslo')
			->setRequired(TRUE);
		$form->addCheckbox('newsletter', 'Newsletter');

		$form->addSubmit('save', 'uložit');
		$form->onSuccess[] = $this->processCustomerForm;
		return $form;
	}

	public function processCustomerForm(EntityForm $form, $values)
	{
		// if editing, password is not required
		if(!$values->password){
			unset($values->password);
		}

        try {
            $form->handler($values);
            $this->onSave($this);
        } catch (UniqueConstraintViolationException $e) {
            $form->addError('This username or email is already taken');
        }

	}


}

interface ICustomerFormFactory
{
	/** @return CustomerForm */
	function create();
}



