<?php
namespace Model;

use Entity\EmailTemplate;

use Kdyby\Doctrine\EntityManager;
use Model\base\BaseService;

class EmailTemplates extends BaseService
{
    /**
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        parent::__construct($em, $em->getRepository(EmailTemplate::class));
    }

    public function findOneByType($type)
    {
        return $this->findOneBy(['type' => $type]);
    }


}