<?php namespace Bishopm\Connexion\Composers;

use Illuminate\Contracts\View\View;
use Bishopm\Connexion\Models\Song;

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
