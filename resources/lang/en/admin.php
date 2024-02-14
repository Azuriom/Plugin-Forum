<?php

return [

    'nav' => [
        'settings' => 'Settings',
        'forums' => 'Forums',
        'tags' => 'Tags',
    ],

    'settings' => [
        'title' => 'Forum settings',
        'home_message' => 'Home message',
        'webhook' => 'Discord Webhook URL',
        'webhook_info' => 'A notification will be sent on this webhook when a new message is posted. Leave empty to disable',
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

        'parent' => 'Parent forum',
        'restricted' => 'Restrict access to this forum to certain roles only',
        'default_tags' => 'Default tags',
        'lock' => 'Lock this forum',
        'lock_info' => 'Users who are not admin will not be able to create discussions.',
        'private' => 'Private forum',
        'private_info' => 'Users can only see their own discussions and pinned ones.',

        'updated' => 'Forums order updated.',
        'delete_error' => 'A forum with discussions or sub-forums can\'t be deleted.',
    ],

    'discussions' => [
        'card' => 'Forum discussions',
    ],

    'posts' => [
        'card' => 'Forum posts',

        'recent' => 'Recent posts in home',
        'delay' => 'Delay between posts',
        'seconds' => 'seconds',
    ],

    'tags' => [
        'title' => 'Tags',
        'create' => 'Create a tag',
        'restricted' => 'Restrict usage to certain roles only.',
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
        'tags' => 'Add or remove tags on their forum discussions',
        'private' => 'View discussions from others users in private forums',
        'delete_own_posts' => 'Delete own forum posts',
        'locked' => 'Create a discussion in a locked forum',
    ],
];
