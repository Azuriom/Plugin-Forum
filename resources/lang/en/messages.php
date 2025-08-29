<?php

return [
    'title' => 'Forum',

    'fields' => [
        'forum' => 'Forum',
        'tags' => 'Tags',
        'editor' => 'Editor',
    ],

    'actions' => [
        'pin' => 'Pin',
        'unpin' => 'Unpin',
        'lock' => 'Lock',
        'unlock' => 'Unlock',
    ],

    'latest' => [
        'title' => 'Latest posts',
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
        'discussions' => ':count discussion|:count discussions',

        'locked' => 'This forum is locked.',
    ],

    'discussions' => [
        'title' => 'Discussions',
        'create' => 'Create discussion',
        'edit' => 'Edit discussion',

        'pin' => 'Pin this discussion',
        'lock' => 'Lock this discussion',

        'respond' => 'Respond',
        'views' => ':count view|:count views',

        'locked' => 'Locked',
        'pinned' => 'Pinned',

        'locked_info' => 'This discussion is locked.',

        'posts' => ':count post|:count posts',

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
        'edit' => 'Edit post',

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
        'mention' => ':user mentioned you in :discussion',
    ],

    'polls' => [
        'create' => 'Add a poll',
        'question' => 'Poll question',
        'options' => 'Poll options',
        'option' => 'Option',
        'multiple_choice' => 'Allow multiple choices',
        'results_before_vote' => 'Show results before voting',
        'remove_vote' => 'Allow users to change or remove their vote',
        'close' => 'Closes at',
        'close_info' => 'Leave empty for no expiration.',

        'vote' => 'Vote',
        'remove' => 'Remove vote',
        'votes' => ':count vote|:count votes',
        'results' => 'Show results',
        'back' => 'Back to vote',
        'closed' => 'Poll closed',
        'closes' => 'Closes in :time',
        'multiple' => 'You can select multiple options.',

        'created' => 'Poll has been created successfully.',
        'voted' => 'Your vote has been recorded.',
        'vote_removed' => 'Your vote has been removed.',
        'deleted' => 'The poll has been deleted.',
        'delete_confirm' => 'Are you sure you want to delete this poll?',
    ],

    'profile' => [
        'likes' => 'Likes',
        'posts' => 'Posts',
        'discussions' => 'Discussions',

        'information' => 'Information',
        'edit' => 'Edit profile',

        'location' => 'Location',
        'website' => 'Website',
        'about' => 'About',
        'signature' => 'Signature',
        'registered' => 'Registered',
        'last_seen' => 'Last seen',
        'display_last_seen' => 'Display last visit',
    ],
];
