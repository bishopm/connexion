<?php namespace bishopm\base\Composers;

use Illuminate\Contracts\View\View;
use bishopm\base\Models\Song;

class SongComposer
{
    /**
     * @var GroupRepository
     */

    public function compose(View $view)
    {
        $tags=Song::allTags()->get();
        $view->with('tags', $tags);
    }
}
