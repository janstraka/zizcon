<?php

namespace AdminModule\Presenters;

use AdminModule\Components\INoticeFormFactory;
use AdminModule\Components\NoticeForm;
use Components\EntityForm;
use Entity\Notice;
use Model\Notices;

class NoticesPresenter extends AdminPresenter
{

	/** @var Notices @inject */
	public $notices;

	/** @var INoticeFormFactory @inject */
	public $notice_form_factory;

	public function startup()
	{
		parent::startup();
	}

	/////////////// Actions & renders

	public function renderDefault()
	{
		$this->template->notices = $this->notices->findAll();
	}


	public function actionEdit($id = null)
	{
	}

	public function actionMySettings()
	{
		$this->redirect('edit', $this->notices->id);
	}


	/////////////// Signals

	public function handleDelete($id)
	{
		$this->notices->delete($this->notices->find($id));

		$this->flashMessage($this->flash->ok);
		$this->redirect('this');
	}


	/////////////// Components

	public function createComponentNoticeForm()
	{
		$notice_form = $this->notice_form_factory->create();

		if ($id = $this->getParameter('id')) {
			$notice_form->setId($id);
		}

		$notice_form->onSave[] = function (NoticeForm $form) {
			$this->flashMessage($this->flash->ok);
			$this->redirect('default');
		};

		return $notice_form;
	}


	/////////////// Other


}