<?php

namespace BaseModule\Presenters;

use BaseModule\Components\TemplateMailer;
use DateInterval;
use Entity\AttendantEvent;
use Entity\EmailTemplate;
use Entity\Event;
use Kdyby\Doctrine\EntityManager;
use Libs\AirbankMailer;
use Model\AttendantEvents;
use Model\Emails;
use Model\Events;
use Nette\InvalidArgumentException;
use Nette\Utils\DateTime;

class CronPresenter extends BasePresenter
{
    /** @var EntityManager @inject */
    public $em;
    /** @var TemplateMailer @inject */
    public $mailer;
    /** @var Emails @inject */
    public $emails;

    // @todo fiksme airbank hashes
    const HASH = 'sdafhlkh234gkjdhfgjk234gkdfsl23h4hkjg'; // don't change it!!!

    public function startup()
    {
        parent::startup();
        if ($this->getParameter('hash') != self::HASH) {
            die('unallowed, provide password');
        }
    }

    public function beforeRender()
    {
        exit;
    }


    //////////////////////////// Actions

    public function actionDefault()
    {
        $this->showHelp();
    }

    //////////////////////////// Other

    private function showHelp()
    {
        echo 'actions available under cron: <br><br>';
        //$this->showHelpLink('sendAttendantReminder', '');
    }

    private function showHelpLink($action, $comment, $only_action_string = false)
    {
        if($only_action_string) {
            echo $action;
        } else {
            $link = $this->link($action, array('hash' => self::HASH));
            echo '<a href="' . $link . '">' . $link . '</a>';
        }
        echo ' - (' . $comment . ')<p />';
    }

}