<?php

return [
    'title' => 'Forum',

    'fields' => [
        'forum' => 'Forum',
        'category' => 'Category',
        'icon' => 'Icon',
    ],

    'actions' => [
        'pin' => 'Pin',
        'unpin' => 'Unpin',
        'lock' => 'Lock',
        'unlock' => 'Unlock',
    ],

    'stats' => [
        'title' => 'Stats',

        'discussions' => 'Discussions: :count',
        'posts' => 'Posts: :count',
        'users' => 'Users: :count',
    ],

    'online' => [
        'title' => 'Online users',

        'none' => 'No online users now...',
    ],

    'forums' => [
        'discussions-count' => ':count discussion|:count discussions',
    ],

    'discussions' => [
        'title' => 'Discussions',
        'title-create' => 'Create discussion',
        'title-edit' => 'Edit discussion',

        'pin' => 'Pin this discussion',
        'lock' => 'Lock this discussion',

        'respond' => 'Respond',

        'locked' => 'Locked',
        'pinned' => 'Pinned',

        'info-locked' => 'This discussion is locked.',

        'posts-count' => ':count post|:count posts',

        'delete' => 'Are you sure you want to delete this discussion ?',

        'status' => [
            'created' => 'The discussion has been created.',
            'updated' => 'This discussion has been modified.',
            'deleted' => 'This discussion has been deleted.',

            'pinned' => 'This discussion has been pinned.',
            'unpinned' => 'This discussion has been unpinned.',
            'locked' => 'This discussion has been locked.',
            'unlocked' => 'This discussion has been unlocked.',
        ],
    ],

    'posts' => [
        'title' => 'Posts',
        'title-edit' => 'Edit post',

        'delay' => 'You can post again in :time.',

        'delete' => 'Are you sure you want to delete this post ?',

        'status' => [
            'created' => 'The post has been created.',
            'updated' => 'This post has been modified.',
            'deleted' => 'This post has been deleted.',
        ],
    ],

    'notifications' => [
        'reply' => ':user has replied to your discussion :discussion',
    ],

    'profile' => [
        'likes' => 'Likes',
        'posts' => 'Posts',
        'discussions' => 'Discussions',
    ],
];
