<?php

namespace BaseModule\Components;

use Entity\EmailLog;
use InvalidArgumentException;
use Latte\Engine;
use Model\EmailLogs;
use Nette\Application\LinkGenerator;
use Nette\Bridges\ApplicationLatte\ILatteFactory;
use Nette\Bridges\ApplicationLatte\UIMacros;
use Nette\Mail\Message;
use Nette\Mail\SendmailMailer;
use Model\EmailTemplates;

class TemplateMailer extends Message
{
    private $sendmail_mailer;
    private $template = [];
    const TEMPLATE_PATH = '/emailTemplate.latte';
    const EVENT_INVITE_TEMPLATE_PATH = '/eventInviteTemplate.latte';

    /** @var LinkGenerator */
    private $link_generator;
    /** var EmailTemplates */
    public $email_templates;
    /** @var ILatteFactory */
    private $latte_factory;
    /** @var EmailLogs @inject */
    public $email_logs;

    public function __construct(SendmailMailer $sendmail_mailer, EmailTemplates $email_templates,
                                LinkGenerator $link_generator, ILatteFactory $latte_factory, EmailLogs $email_logs)
    {
        parent::__construct();
        $this->sendmail_mailer = $sendmail_mailer;
        $this->email_templates = $email_templates;
        $this->link_generator = $link_generator;
        $this->latte_factory = $latte_factory;
        $this->email_logs = $email_logs;
    }


    /////////////// Public

    public function setFrom($email, $name = NULL)
    {
        parent::setFrom($email, $name);
        return $this;
    }

    public function addTo($email, $name = NULL)
    {
        parent::addTo($email, $name);
        return $this;
    }

    public function addCc($email, $name = NULL)
    {
        parent::addCc($email, $name);
        return $this;
    }

    public function addBcc($email, $name = NULL)
    {
        parent::addBcc($email, $name);
        return $this;
    }

    public function setSubject($subject)
    {
        parent::setSubject($subject);
        return $this;
    }

    public function setBasePath($base_path)
    {
        $this->template['basePath'] = $base_path;
        return $this;
    }

    public function setContent($content)
    {
        $this->template['content'] = $content;
        return $this;
    }

    public function setUnsubscribeLink($link)
    {
        $this->template['unsubscribe_link'] = $link;
        return $this;
    }

    public function send($template_path = self::TEMPLATE_PATH)
    {
        if(!$this->template){
            throw new InvalidArgumentException('$this->template has no content, fill it please by setContent() method');
        }

        // todo connect translator?
        // set before sending to pass $this->template params
        //$latte = new Engine;


        $latte = $this->latte_factory->create();

        // nainstalujme do $latte makra {link} a n:href
        UIMacros::install($latte->getCompiler());

        $this->template['_control'] = $this->link_generator;

        $this->setHtmlBody($latte->renderToString(__DIR__ . $template_path, $this->template));

        try {
            $this->sendmail_mailer->send($this);
        } catch (\Exception $e){

            $log = new EmailLog;

            // fiksme Překlad emailu z headers asi nebude takhle ideální, nebo?
            $emails = $this->getHeader('To');
            foreach($emails as $email => $item){
                $log->email = $email;
            }

            $log->class = get_class($e);
            $log->message = $e->getMessage();
            $log->date = new \DateTime("now");

            $this->email_logs->save($log);
        }

    }



    /**
     * Use only for testing/coding purposes
     */
    public function renderTemplate()
    {
        $latte = $this->latte_factory->create();

        // nainstalujme do $latte makra {link} a n:href
        UIMacros::install($latte->getCompiler());

        $params = [
            'content' => '',
            '_control' => $this->link_generator,
        ];
        //$latte = new \Latte\Engine;
        echo $latte->renderToString(__DIR__ . self::TEMPLATE_PATH, $params);
    }


    public function sendEmailTemplate($template, $event, $link, $email, $from = '')
    {
        $this->template = [
            'content' => $template,
            'basePath' => self::EVENT_INVITE_TEMPLATE_PATH,
            'event' => $event,
            'link' => $link,
        ];

        // fiksme calendar header
        $this->setFrom($from);
        $this->addTo($email);
        $this->send(self::EVENT_INVITE_TEMPLATE_PATH);
    }
    /////////////// Private

}