<?php namespace Bishopm\Connexion\Composers;

use Illuminate\Contracts\View\View;
use Bishopm\Connexion\Repositories\SlideshowsRepository;

class SlideComposer
{
    /**
     * @var GroupRepository
     */
    private $slideshow;

    public function __construct(SlideshowsRepository $slideshow)
    {
        $this->slideshow=$slideshow;
    }

    public function compose(View $view)
    {
        $view->with('slideshow', $this->slideshow->byName('back'));
    }
}
