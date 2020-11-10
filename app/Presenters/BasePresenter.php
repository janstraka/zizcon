<?php

namespace App\Presenters;

use Nette\Application\UI\Presenter;
use Nette\Database\Context;
use App\Model\SponsorManager;

abstract class BasePresenter extends Presenter
{

    /** @var SponsorManager */
    private $sponsorManager;

    public function __construct(SponsorManager $sponsorManager)
    {
        $this->sponsorManager = $sponsorManager;
    }

    public function beforeRender()
    {
        parent::beforeRender();
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
    }

    public function renderDefault(): void
    {
        $this->template->sponsors = $this->sponsorManager->getActiveSponsors();
    }
}