<?php

namespace Libs;

use BaseModule\Components\TemplateMailer;
use Entity\AttendantEvent;
use Entity\EmailTemplate;
use Model\EmailTemplates;
use Nette\Application\LinkGenerator;
use Nette\DI\Container;
use Nette\NotImplementedException;
use Nette\Object;
use Nette\Utils\ArrayHash;

class AirbankMailer extends Object
{
    /** @var TemplateMailer */
    public $template_mailer;
    /** @var EmailTemplates */
    public $email_templates;
    /** @var LinkGenerator */
    private $link_generator;

    private $neon;

    public function __construct(TemplateMailer $template_mailer, EmailTemplates $email_templates,
                                LinkGenerator $link_generator, Container $context)
    {
        $this->template_mailer = $template_mailer;
        $this->email_templates = $email_templates;
        $this->link_generator = $link_generator;
        $this->neon = ArrayHash::from($context->parameters);
    }

    public function sendEmail($token, $type, $email_to)
    {

        $template = $this->email_templates->findOneByType($type);


        //$template->content = str_replace('{$link_decline}', '<a href="' . $this->link_generator->link('//:Front:' . ucfirst($type) . ':eventInvite', $token, 'declined') . '">Zam�tnout</a>', $template->content);
        //$template->content = str_replace('{$list}', $sinners, $template->content);


        $mailer = clone $this->template_mailer;
        $mailer->setFrom($this->neon->email_from)
            ->addTo($email_to)
            ->setSubject($template->subject)
            ->setContent($template->content)
            ->send();
    }

    public function sendSinnersEmail($email_to, $sinners_list)
    {
        $template = $this->email_templates->findOneByType(EmailTemplate::TYPE_SINNERS);
        $template->content = $template->content . $sinners_list;

        $this->send($email_to, $template);
    }

    public function sendFeedbackEmail($email_to, $token)
    {
        $template = $this->email_templates->findOneByType(EmailTemplate::TYPE_FEEDBACK);
        $link_feedback = $this->link_generator->link('Front:Attendant:eventFeedback', ['token' => $token]);

        $link_href = '<a href="' . $link_feedback . '">Zadat feedback do systému</a>';

        $template->content = $template->content . $link_href;

        $this->send($email_to, $template);
    }

    // jak pro Attendant, tak pro Lector
    public function sendInviteEmail($email_to, $token, $type)
    {
        $template = $this->email_templates->findOneByType($type);

        if($type == EmailTemplate::TYPE_REMINDER){ // maly hack
            $type = 'Attendant';
        }

        $link_accept = $this->link_generator->link('Front:' . ucfirst($type) . ':eventInvite', [
            'token' => $token,
            'status' => AttendantEvent::STATUS_ACCEPTED
        ]);
        $link_href = '<a href="' . $link_accept . '">Přijmout pozvánku</a>';

        $template->content = $template->content . $link_href;

        $this->send($email_to, $template);
    }


    private function send($email_to, $template)
    {
        $mailer = clone $this->template_mailer;
        $mailer->setFrom($this->neon->email_from)
            ->addTo($email_to)
            ->setSubject($template->subject)
            ->setContent($template->content)
            ->send();
    }
}