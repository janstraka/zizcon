<?php

namespace AdminModule\Components;

use Components\EntityForm;
use Entity\User;
use Model\Users;
use Nette;
use Nette\Application\UI;
use Nette\Application\UI\Form;

class UserForm extends UI\Control
{
    /** @var Users */
    private $users;

    public $onSave = [];

	public function __construct(Users $users)
	{
		parent::__construct();
        $this->users = $users;
	}

	public function render()
	{
		$this->template->render(__DIR__ . '/userForm.latte');
	}

    public function setId($id)
    {
        /** @var EntityForm $form */
		$form = $this['userForm'];

		$form->bindEntity($this->users->find($id));
		$form['password']->setRequired(FALSE);
    }

    protected function createComponentUserForm()
	{
		$form = new EntityForm;
		$form->setEntityService($this->users);
        $form->bindEntity(new User);

		$form->addFormFiller('form_filler', $this->getTestingFields());

        $form->addText('email', 'email')
            ->addRule(Form::EMAIL, 'Vyplňte správný email');
		$form->addText('password', 'heslo')
			->setRequired();
		$form->addText('name','Jméno')
			->setRequired();
		$form->addText('surname','Příjmení')
			->setRequired();
		$form->addText('phone','Telefon')
			->setRequired();

		$form->addSubmit('save', 'uložit');
		$form->onSuccess[] = $this->processUserForm;
		return $form;
	}
    

	public function processUserForm(EntityForm $form, $values)
	{
		// if editing, password is not required
		if(!$values->password){
			unset($values->password);
		}

        /*if ($values->photo->isOk()) {
            $image = $this->image_storage->upload($values->photo);
            $values->photo = $image;
        } else {
            unset($values->photo);
        }*/

		$form->handler($values);

		$this->onSave($this);
	}

	private function getTestingFields(){
		return [
			'email' => 'email',
			'password' => 'text',
			'name' => 'text',
			'surname' => 'text',
			'phone' => 'phone',
		];
	}
}

interface IUserFormFactory
{
	/** @return UserForm */
	function create();
}



