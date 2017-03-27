<?php namespace Bishopm\Connexion\Composers;

use Illuminate\Contracts\View\View;
use Bishopm\Connexion\Repositories\MenuitemsRepository;
use Spatie\Menu\Laravel\Menu, Spatie\Menu\Laravel\Link;

class MenuComposer
{
    /**
     * @var GroupRepository
     */
    private $menuitems;

    public function __construct(MenuitemsRepository $menuitems)
    {
        $this->menu=$menuitems->makeMenu(1);
        $this->footer=$menuitems->makeFooter(1);
    }

    public function compose(View $view)
    {
        $view->with('webmenu', $this->menu);
        $view->with('webfooter', $this->footer);
    }
}
