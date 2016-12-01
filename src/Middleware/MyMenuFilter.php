<?php

namespace bishopm\base\Middleware;

use JeroenNoten\LaravelAdminLte\Menu\Builder;
use JeroenNoten\LaravelAdminLte\Menu\Filters\FilterInterface;
use Laratrust;

class MyMenuFilter implements FilterInterface
{	
    public function transform($item, Builder $builder) {

    	if (array_key_exists('permission', $item)) {
	        if (!Laratrust::can($item['permission'])) {
	            return false;
	        } 
	    } 
		if (array_key_exists('header', $item)) {
	        if (isset($item['header'])) {
	            $item = $item['header'];
	        }
	    }

        return $item;
    }
}