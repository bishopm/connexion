<?php

namespace Bishopm\Connexion\Presenters;

use Nwidart\Menus\Presenters\Presenter;

class Bootstrap4Presenter extends Presenter
{
    /**
     * {@inheritdoc }.
     */
    public function getOpenTagWrapper()
    {
        return PHP_EOL . '<ul class="navbar-nav mr-auto">' . PHP_EOL;
    }

    /**
     * {@inheritdoc }.
     */
    public function getCloseTagWrapper()
    {
        return PHP_EOL . '</ul>' . PHP_EOL;
    }

    /**
     * {@inheritdoc }.
     */
    public function getMenuWithoutDropdownWrapper($item)
    {
        return '<li class="nav-item"' . $this->getActiveState($item) . '><a class="nav-link" href="' . $item->getUrl() . '" ' . $item->getAttributes() . '>' . $item->getIcon() . ' ' . $item->title . '</a></li>' . PHP_EOL;
    }

    /**
     * {@inheritdoc }.
     */
    public function getActiveState($item, $state = ' class="active"')
    {
        return $item->isActive() ? $state : null;
    }

    /**
     * Get active state on child items.
     *
     * @param $item
     * @param string $state
     *
     * @return null|string
     */
    public function getActiveStateOnChild($item, $state = 'active')
    {
        return $item->hasActiveOnChild() ? $state : null;
    }

    /**
     * {@inheritdoc }.
     */
    public function getDividerWrapper()
    {
        return '<li class="divider"></li>';
    }

    /**
     * {@inheritdoc }.
     */
    public function getHeaderWrapper($item)
    {
        return '<li class="dropdown-header">' . $item->title . '</li>';
    }

    /**
     * {@inheritdoc }.
     */
    public function getMenuWithDropDownWrapper($item)
    {
        $fin='<li class="nav-item dropdown' . $this->getActiveStateOnChild($item, ' active') . '">
        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
          ' . $item->getIcon() . ' ' . $item->title . '
        </a>
        <div class="dropdown-menu">';
        foreach ($item->childs as $child) {
            $fin.='<a class="dropdown-item" href="' . $child->url . '">' . $child->title . '</a>';
        }
        $fin.='</div></li>' . PHP_EOL;
        return $fin;
    }

    /**
     * Get multilevel menu wrapper.
     *
     * @param \Nwidart\Menus\MenuItem $item
     *
     * @return string`
     */
    public function getMultiLevelDropdownWrapper($item)
    {
        return '<li class="nav-item dropdown' . $this->getActiveStateOnChild($item, ' active') . '">
		          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
					' . $item->getIcon() . ' ' . $item->title . '
			      	<b class="caret pull-right caret-right"></b>
			      </a>
			      <div class="dropdown-menu">
			      	' . $this->getChildMenuItems($item) . '
			      </div>
		      	</li>'
        . PHP_EOL;
    }
}
