<?php

namespace Bishopm\Connexion\Middleware;

use JeroenNoten\LaravelAdminLte\Menu\Builder;
use JeroenNoten\LaravelAdminLte\Menu\Filters\FilterInterface;

class MyMenuFilter implements FilterInterface
{	
    public function transform($item, Builder $builder)
    {
        if (isset($item['permission']) && ! Laratrust::can($item['permission'])) {
            return false;
        }
        
        if (isset($item['header'])) {
            $item = $item['header'];
        }

        return $item;
    }

}