<?php

namespace Azuriom\Plugin\Forum\View\Composers;

use Azuriom\Extensions\Plugin\AdminDashboardCardComposer;
use Azuriom\Plugin\Forum\Models\Discussion;
use Azuriom\Plugin\Forum\Models\Post;

class ForumAdminDashboardComposer extends AdminDashboardCardComposer
{
    public function getCards()
    {
        return [
            'forum_discussions' => [
                'color' => 'primary',
                'name' => trans('forum::admin.discussions.card'),
                'value' => Discussion::count(),
                'icon' => 'fas fa-comments',
            ],
            'forum_posts' => [
                'color' => 'success',
                'name' => trans('forum::admin.posts.card'),
                'value' => Post::count(),
                'icon' => 'fas fa-comment',
            ],
        ];
    }
}
