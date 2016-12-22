<?php namespace bishopm\base\Composers;

use Illuminate\Contracts\View\View;
use bishopm\base\Repositories\MenuitemsRepository;
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
    }

    public function compose(View $view)
    {
        $view->with('webmenu', $this->menu);
    }
}
