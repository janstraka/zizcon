<?php

namespace AdminModule\Presenters;


use AdminModule\Components\ISignInFormFactory;
use AdminModule\Components\SignInForm;

class SignPresenter extends AdminPresenter
{

    /** @var ISignInFormFactory @inject */
    public $sign_in_form_factory;

    /** @return SignInForm */
    protected function createComponentSignInForm()
    {
        return $this->sign_in_form_factory->create();
    }

    public function actionOut()
    {
        $this->getUser()->logout();
        $this->flashMessage($this->flash->sign_out);
        $this->redirect(':Front:Default:');
    }
}