<?php

return [

    'nav' => [
        'settings' => 'Settings',
        'forums' => 'Forums',
        'tags' => 'Tags',
    ],

    'settings' => [
        'title' => 'Forum settings',
    ],

    'categories' => [
        'title' => 'Categories',
        'edit' => 'Edit category :category',
        'create' => 'Create category',

        'delete_error' => 'This category contain forums and can\'t be deleted.',
    ],

    'forums' => [
        'title' => 'Forums',
        'create' => 'Create forum',
        'edit' => 'Edit forum :forum',

        'create_category' => 'Create category',
        'create_forum' => 'Create forum',

        'restricted' => 'Restrict access to this forum to certain roles only',
        'default_tags' => 'Default tags',
        'lock' => 'Lock this forum',
        'lock_info' => 'Users who are not admin will not be able to create discussions.',

        'updated' => 'Forums order updated.',
        'delete_error' => 'A forum with discussions or sub-forums can\'t be deleted.',
    ],

    'discussions' => [
        'card' => 'Forum discussions',
    ],

    'posts' => [
        'card' => 'Forum posts',

        'delay' => 'Delay between posts',
        'seconds' => 'seconds',
    ],

    'tags' => [
        'title' => 'Tags',
        'create' => 'Create a tag',
    ],

    'logs' => [
        'forum-discussions' => [
            'deleted' => 'Deleted discussion #:id',
            'pinned' => 'Pinned discussion #:id',
            'unpinned' => 'Unpinned discussion #:id',
            'locked' => 'Locked discussion #:id',
            'unlocked' => 'Unlocked discussion #:id',
        ],

        'forum-posts' => [
            'deleted' => 'Deleted post #:id',
        ],

        'forum-categories' => [
            'created' => 'Created forum category #:id',
            'updated' => 'Updated forum category #:id',
            'deleted' => 'Deleted forum category #:id',
        ],

        'forum-forums' => [
            'created' => 'Created forum #:id',
            'updated' => 'Updated forum #:id',
            'deleted' => 'Deleted forum #:id',
        ],
    ],

    'permissions' => [
        'forums' => 'Manage forums and categories',
        'discussions' => 'Manage forum discussions (move, edit, delete, pin, lock)',
        'delete_own_posts' => 'Delete own forum posts',
    ],
];
