<?php

namespace AdminModule\Presenters;


use AdminModule\Components\emailForm;
use AdminModule\Components\IEmailFormFactory;
use Model\Emails;

use BaseModule\Components\TemplateMailer;


class EmailsPresenter extends AdminPresenter
{

    /** @var Emails @inject */
    public $emails;
    /** @var IEmailFormFactory @inject */
    public $emails_form_factory;
    /** @var TemplateMailer @inject */
    public $mailer;

    public $onSave = [];
    public function startup()
    {
        parent::startup();
        //$this->breadcrumb->addLink('Customers', $this->link('Customers:'));
    }

    /////////////// Actions & renders

    public function actionDefault()
    {
        $this->template->emails = $this->emails->findAll();
    }


    public function actionEdit($id = null)
    {
        //$this->breadcrumb->addLink('edit', $this->link('Category:edit', $id));

        //$this['customersForm']->bindEntity($this->getCustomerEntity($id));

    }

    public function actionMySettings()
    {
        $this->redirect('edit', $this->email->id);
    }


    /////////////// Signals

    public function handleDelete($id)
    {
        $this->emails->delete($this->emails->find($id));

        $this->flashMessage($this->flash->ok);
        $this->redirect('this');
    }

    // @todo EXTRACT MAILER CLASS SERVICE?
    public function handleSendNewsletter()
    {
        $emails = $this->emails->findall();
        /*
        $menu = $this->menus->getCurrentMenu();
        if (!$menu) {
            $this->flashMessage("no menu not available", "warning");
            $this->redirect('this');
        }

        foreach($emails as $email){
            $mailer = clone($this->mailer);
            $mailer->sendNewsletters($this->neon->email_from, $email, $menu);
        }
        */
        $this->flashMessage($this->flash->ok);
        $this->redirect('this');
    }

    /////////////// Components

    public function createComponentEmailForm()
    {
        $email_form = $this->emails_form_factory->create();

        if($id = $this->getParameter('id')){
            $email_form->setId($id);
        }

        $email_form->onSave[] = function(EmailForm $form){
            $this->flashMessage($this->flash->ok);
            $this->redirect('default');
        };

        return $email_form;
    }



    /////////////// Other


}