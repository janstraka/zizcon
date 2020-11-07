<?php

namespace App\Presenters;

use Nette\Application\UI\Presenter;

abstract class BasePresenter extends Presenter
{

    public function beforeRender()
    {
        parent::beforeRender(); // nezapomeňte volat metodu předka, stejně jako u startup()
        $this->template->logMenuItems = [];
        $this->template->mainMenuItems = [
            'Hlavní strana' => 'Homepage:default',
            'Fotogalerie' => 'Gallery:default',
            'Seznam aktivit' => 'ActivityList:default',
            'Forum' => 'Forum:default',
        ];

        if ($this->getUser()->isLoggedIn()) {
            $this->template->mainMenuItems['Program'] = 'Program:default';
            $this->template->logMenuItems['Odhlásit'] = 'Sign:out';
            $this->template->logMenuItems['Profil'] = 'Sign:in';
        } else {
            $this->template->logMenuItems['Přihlásit'] = 'Sign:in';
            $this->template->logMenuItems['Registrovat'] = 'Sign:in';
        }

        // $this->flashMessage('TEST.');
    }
}