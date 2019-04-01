<?php

namespace FrontModule\Presenters;


use App\Forms\ITicketFormFactory;
use App\Model;
use App\Model\Entity\Reservation;
use DateTime;
use FrontModule\Presenters\FrontPresenter;
use Nette;
use Nette\Application\UI\Form;
use Model\Reservations;



class TicketsPresenter extends FrontPresenter
{

	/** @var  ITicketFormFactory @inject */
	public $ticket_form_factory;

	/** @var  Reservations @inject */
	public $reservations;


	public function startup()
	{
		parent::startup();
		$this->template->title = "Lístky";
	}

	public function actionDefault()
	{

	}

	/**
	 * Sign-in form factory.
	 * @return Nette\Application\UI\Form
	 */
	protected function createComponentTicketForm()
	{
		//$form = new Form;

		$form = $this->ticket_form_factory->create();

		$form->onSave[] = function () {
			$this->flashMessage("Rezervace proběhla úspěšně", "info");
			$this->redirect('this');
		};

		return $form;
	}
}
