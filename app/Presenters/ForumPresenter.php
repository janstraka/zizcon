<?php

namespace App\Presenters;

use Nette;
use App\Model\ArticleManager;
use App\Model\SponsorManager;


class ForumPresenter extends BasePresenter
{
    /** @var ArticleManager */
    private $articleManager;
    /** @var SponsorManager */
    private $sponsorManager;

    public function __construct(ArticleManager $articleManager, SponsorManager $sponsorManager)
    {
        parent::__construct($sponsorManager);
        $this->articleManager = $articleManager;
    }

    public function renderDefault(): void
    {
        parent::renderDefault();
        $this->template->posts = $this->articleManager->getPublicArticles()->limit(5);
    }
}