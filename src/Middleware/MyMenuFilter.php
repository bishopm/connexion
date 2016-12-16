<?php

namespace bishopm\base\Middleware;

use JeroenNoten\LaravelAdminLte\Menu\Builder;
use JeroenNoten\LaravelAdminLte\Menu\Filters\FilterInterface;
use Illuminate\Support\Facades\Auth;

class MyMenuFilter implements FilterInterface
{	
    public function transform($item, Builder $builder) {
    	$user=Auth::user();
    	if (array_key_exists('can', $item)) {
	        if (!$user->can($item['can'])) {
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