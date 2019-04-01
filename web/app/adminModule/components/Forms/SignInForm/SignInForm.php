<?php

namespace AdminModule\Components;

use Libs\DivRenderer\BsForm;
use Nette;
use Nette\Application\UI;
use Nette\Application\UI\Form;
use Nette\Security\AuthenticationException;

class SignInForm extends UI\Control
{

	/** @persistent */
	public $backlink = '';

    public $onSave = [];

	public function __construct()
	{
		parent::__construct();
	}

	public function render()
	{
		$this->template->render(__DIR__ . '/signInForm.latte');
	}

	/**
	 * Sign-in form factory.
	 * @return Form
	 */
	protected function createComponentSignInForm()
	{
		$form = new BsForm;

		$form->addText('email')
			->addRule(Form::EMAIL, 'Vyplňte správný email');
		$form->addPassword('password')
			->setRequired('Zadejte prosím správné heslo.');
		$form->addCheckbox('remember');

		$form->addSubmit('save');
		$form->onSuccess[] = $this->signInFormSucceeded;
		return $form;
	}

	public function signInFormSucceeded(Form $form, $values)
	{
        $user = $this->presenter->user;
        $values->remember
            ? $user->setExpiration('+ 14 days', FALSE)
            : $user->setExpiration('+ 20 minutes', TRUE);

		try {
			$user->login($values->email, $values->password);
		} catch (AuthenticationException $e) {
			$form->addError($e->getMessage());
			return;
		}

        // fiksme nechat se postarat o toto presenter, pak nebude potreba to hackovat
		$this->restoreRequestIfInSession();
		$this->presenter->redirect(':Admin:Admin:');

        $this->onSave($this);
	}

	// get back to the previous page before signing in ;hacked request, nette bug probably?
	private function restoreRequestIfInSession()
	{
		if(isset($_SESSION['__NF']['DATA']['Nette.Application/requests'])){
			$this->presenter->restoreRequest(key($_SESSION['__NF']['DATA']['Nette.Application/requests']));
		}
	}


}

interface ISignInFormFactory
{
	/** @return SignInForm */
	function create();
}
