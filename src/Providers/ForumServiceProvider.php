<?php

namespace Azuriom\Plugin\Forum\Providers;

use Azuriom\Extensions\Plugin\BasePluginServiceProvider;
use Azuriom\Models\ActionLog;
use Azuriom\Models\Permission;
use Azuriom\Plugin\Forum\Models\Category;
use Azuriom\Plugin\Forum\Models\Discussion;
use Azuriom\Plugin\Forum\Models\Forum;
use Azuriom\Plugin\Forum\Models\Post;
use Azuriom\Plugin\Forum\Policies\DiscussionPolicy;
use Azuriom\Plugin\Forum\Policies\ForumPolicy;
use Azuriom\Plugin\Forum\Policies\PostPolicy;
use Azuriom\Plugin\Forum\View\Composers\ForumAdminDashboardComposer;
use Illuminate\Support\Facades\View;

class ForumServiceProvider extends BasePluginServiceProvider
{
    /**
     * The policy mappings for this plugin.
     *
     * @var array
     */
    protected $policies = [
        Post::class => PostPolicy::class,
        Discussion::class => DiscussionPolicy::class,
        Forum::class => ForumPolicy::class,
    ];

    /**
     * Register any plugin services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any plugin services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        $this->loadViews();

        $this->loadTranslations();

        $this->loadMigrations();

        $this->registerRouteDescriptions();

        $this->registerAdminNavigation();

        $this->registerPermissions();

        $this->registerLogActions();

        View::composer('admin.dashboard', ForumAdminDashboardComposer::class);
    }

    protected function registerPermissions()
    {
        Permission::registerPermissions([
            'forum.forums' => 'forum::admin.permissions.forums',
            'forum.discussions' => 'forum::admin.permissions.discussions',
            'forum.posts.delete.self' => 'forum::admin.permissions.delete-self-post',
        ]);
    }

    protected function registerLogActions()
    {
        ActionLog::registerLogModels([
            Category::class,
            Forum::class,
            Discussion::class,
            Post::class,
        ], 'forum::admin.logs');

        ActionLog::registerLogs([
            'forum-discussions.locked' => [
                'icon' => 'lock',
                'color' => 'info',
                'message' => 'forum::admin.logs.forum-discussions.locked',
                'model' => Discussion::class,
            ],
            'forum-discussions.unlocked' => [
                'icon' => 'lock-open',
                'color' => 'info',
                'message' => 'forum::admin.logs.forum-discussions.unlocked',
                'model' => Discussion::class,
            ],
            'forum-discussions.pinned' => [
                'icon' => 'thumbtack rotate-45',
                'color' => 'info',
                'message' => 'forum::admin.logs.forum-discussions.pinned',
                'model' => Discussion::class,
            ],
            'forum-discussions.unpinned' => [
                'icon' => 'thumbtack rotate-45',
                'color' => 'info',
                'message' => 'forum::admin.logs.forum-discussions.unpinned',
                'model' => Discussion::class,
            ],
        ]);
    }

    /**
     * Returns the routes that should be able to be added to the navbar.
     *
     * @return array
     */
    protected function routeDescriptions()
    {
        return [
            'forum.home' => 'forum::messages.title',
        ];
    }

    /**
     * Return the admin navigations routes to register in the dashboard.
     *
     * @return array
     */
    protected function adminNavigation()
    {
        return [
            'forum' => [
                'name' => 'forum::messages.title',
                'type' => 'dropdown',
                'icon' => 'fas fa-comments',
                'route' => 'forum.admin.*',
                'permission' => 'forum.forums',
                'items' => [
                    'forum.admin.settings' => 'forum::admin.nav.settings',
                    'forum.admin.forums.index' => 'forum::admin.nav.forums',
                    'forum.admin.tags.index' => 'forum::admin.nav.tags',
                ],
            ],
        ];
    }
}
