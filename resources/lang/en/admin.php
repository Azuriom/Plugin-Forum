<?php

return [

    'nav' => [
        'settings' => 'Settings',
        'forums' => 'Forums',
    ],

    'settings' => [
        'title' => 'Forum settings',
    ],

    'categories' => [
        'title' => 'Categories',
        'title-edit' => 'Edit category :category',
        'title-create' => 'Create category',

        'status' => [
            'created' => 'The category has been created.',
            'updated' => 'This category has been modified.',
            'deleted' => 'This category has been deleted.',

            'delete-not-empty' => 'This category contain forums and can\'t be deleted.',
        ],
    ],

    'forums' => [
        'title' => 'Forums',
        'title-create' => 'Create forum',
        'title-edit' => 'Edit forum :forum',

        'create-category' => 'Create category',
        'create-forum' => 'Create forum',

        'icons' => 'You can find the list of available icons on <a href="https://fontawesome.com/icons?d=gallery&m=free" target="_blank" rel="noopener noreferrer">FontAwesome</a>.',

        'lock' => 'Lock this forum',
        'lock-info' => 'Users who are not admin will not be able to create discussions.',

        'status' => [
            'created' => 'The forums has been created.',
            'updated' => 'This forums has been modified.',
            'deleted' => 'This forums has been deleted.',

            'order-updated' => 'Forums order updated.',

            'delete-not-empty' => 'This forums contain discussions and can\'t be deleted.',
            'delete-with-forums' => 'A forum with sub forums can\'t be deleted.',
        ],
    ],

    'discussions' => [
        'card' => 'Forum discussions',
    ],

    'posts' => [
        'card' => 'Forum posts',

        'delay' => 'Delay between posts',
        'seconds' => 'seconds',
    ],

    'logs' => [
        'discussions' => [
            'deleted' => 'Deleted discussion #:id',
            'pinned' => 'Pinned discussion #:id',
            'unpinned' => 'Unpinned discussion #:id',
            'locked' => 'Locked discussion #:id',
            'unlocked' => 'Unlocked discussion #:id',
        ],

        'posts' => [
            'deleted' => 'Deleted post #:id',
        ],

        'categories' => [
            'created' => 'Created forum category #:id',
            'updated' => 'Updated forum category #:id',
            'deleted' => 'Deleted forum category #:id',
        ],

        'forums' => [
            'created' => 'Created forum #:id',
            'updated' => 'Updated forum #:id',
            'deleted' => 'Deleted forum #:id',
        ],
    ],

    'permissions' => [
        'forums' => 'View and manage support forums and categories',
        'discussions' => 'View and manage forum discussions (move, edit, delete, pin, lock)',
        'delete-self-post' => 'Delete own forum posts',
    ],
];
