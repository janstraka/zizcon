<?php

namespace App\Presenters;

use Nette;
use App\Model\GalleryManager;
use App\Model\SponsorManager;


class GalleryPresenter extends BasePresenter
{
    /** @var GalleryManager */
    private $galleryManager;
    /** @var SponsorManager */
    private $sponsorManager;

    public function __construct(GalleryManager $galleryManager, SponsorManager $sponsorManager)
    {
        parent::__construct($sponsorManager);
        $this->galleryManager = $galleryManager;
    }

    public function renderDefault(): void
    {
        parent::renderDefault();
        $this->template->gallery = $this->galleryManager->getGalleryPictures();
    }
}