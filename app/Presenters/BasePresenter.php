<?php

namespace App\Presenters;

use Nette\Application\UI\Presenter;

abstract class BasePresenter extends Presenter
{

    public function beforeRender()
    {
        parent::beforeRender(); // nezapomeňte volat metodu předka, stejně jako u startup()
        $this->template->menuItems = [
            'Hlavní strana' => 'Homepage:default',
            'Fotogalerie' => 'Gallery:default',
            'Seznam aktivit' => 'ActivityList:default',
            'Forum' => 'Forum:default',
        ];
        if ($this->getUser()->isLoggedIn()) {
            $this->template->menuItems['Program'] = 'Program:default';
            $this->template->menuItems['Odhlásit'] = 'Sign:out';
        } else {
            $this->template->menuItems['Přihlásit'] = 'Sign:in';
        }
    }
    
}