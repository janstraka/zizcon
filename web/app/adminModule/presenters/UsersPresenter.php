<?php

namespace AdminModule\Presenters;

use AdminModule\Components\CustomerForm;
use AdminModule\Components\ICustomerFormFactory;
use AdminModule\Components\IUserFormFactory;
use AdminModule\Components\UserForm;
use Components\EntityForm;
use Entity\Customer;
use Model\Customers;
use Model\Users;

class UsersPresenter extends AdminPresenter
{

    /** @var Users @inject */
    public $users;
    /** @var IUserFormFactory @inject */
    public $user_form_factory;

    public function startup()
    {
        parent::startup();
    }

    /////////////// Actions & renders

    public function renderDefault()
    {
        $this->template->users = $this->users->findAll();
    }


    public function actionEdit($id = null)
    {
    }

    public function actionMySettings()
    {
        $this->redirect('edit', $this->user->id);
    }


    /////////////// Signals

    public function handleDelete($id)
    {
        $this->users->delete($this->users->find($id));

        $this->flashMessage($this->flash->ok);
        $this->redirect('this');
    }


    /////////////// Components

    public function createComponentUserForm()
    {
        $user_form = $this->user_form_factory->create();

        if($id = $this->getParameter('id')){
            $user_form->setId($id);
        }

        $user_form->onSave[] = function(UserForm $form){
            $this->flashMessage($this->flash->ok);
            $this->redirect('default');
        };

        return $user_form;
    }



    /////////////// Other


}