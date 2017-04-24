<?php namespace Bishopm\Connexion\Composers;

use Illuminate\Contracts\View\View;
use Bishopm\Connexion\Repositories\SlidesRepository;

class SlideComposer
{
    /**
     * @var GroupRepository
     */
    private $slides;

    public function __construct(SlidesRepository $slides)
    {
        $this->slides=$slides->getSlideshow('back');
    }

    public function compose(View $view)
    {
        $view->with('slides', $this->slides);
        $view->with('slideshow', "back");
    }
}
