<?php

namespace AdminModule\Presenters;


use Components\EntityForm;
use Entity\SettingsExchangeRate;
use Entity\SettingsVat;
use Model\BaseService;
use Kdyby\Doctrine\EntityManager;

class SettingsPresenter extends AdminPresenter
{

    /** @var EntityManager @inject */
    public $em;


    public function startup()
    {
        parent::startup();
    }

    /////////////// Actions & renders

    public function actionDefault()
    {
        $settings_vat = $this->em->find(SettingsVat::class, 1);
        $this['settingsVatForm']->bindEntity($settings_vat);

        $settings_exchange_rate = $this->em->find(SettingsExchangeRate::class, 1);
        $this['settingsExchangeRateForm']->bindEntity($settings_exchange_rate);
    }


    /////////////// Signals


    /////////////// Components


    public function createComponentSettingsVatForm()
    {
        $form = new EntityForm;

        //$form->addSelect('is_vat', 'Is VAT:', array('no', 'yes'));
        $form->addText('vat', 'VAT:');

        return $this->getBaseForm($form);
    }

    public function createComponentSettingsExchangeRateForm()
    {
        $form = new EntityForm;

        $form->addText('czk', 'Czk:');

        return $this->getBaseForm($form);
    }



    public function processSettingsForm(EntityForm $form, $values)
    {
        $form->handler($values);

        $this->flashMessage($this->flash->ok);
        $this->redirect('default');
    }


    /////////////// Other


    private function getBaseForm(EntityForm $form)
    {
        $form->setEntityService(new BaseService($this->em));

        $form->addSubmit('save', 'save');

        $form->onSuccess[] = $this->processSettingsForm;
        return $form;
    }

}