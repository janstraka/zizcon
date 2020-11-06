<?php

namespace App\Presenters;

use Nette;
use App\Model\ArticleManager;


class HomepagePresenter extends BasePresenter
{
    /** @var ArticleManager */
    private $articleManager;

    public function __construct(ArticleManager $articleManager)
    {
        $this->articleManager = $articleManager;
    }

    public function renderDefault(): void
    {
        $this->template->posts = $this->articleManager->getPublicArticles()->limit(5);
    }
}