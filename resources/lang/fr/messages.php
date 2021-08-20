<?php

return [
    'title' => 'Forum',

    'fields' => [
        'forum' => 'Forum',
        'tags' => 'Étiquettes',
        'editor' => 'Éditeur',
    ],

    'actions' => [
        'pin' => 'Épingler',
        'unpin' => 'Désépingler',
        'lock' => 'Verrouiller',
        'unlock' => 'Déverrouiller',
    ],

    'latest' => [
        'title' => 'Derniers messages',
    ],

    'stats' => [
        'title' => 'Stats',

        'discussions' => 'Discussions: :count',
        'posts' => 'Messages: :count',
        'users' => 'Utilisateurs: :count',
    ],

    'online' => [
        'title' => 'Utilisateurs en ligne',

        'none' => 'Aucun utilisateur en ligne...',
    ],

    'forums' => [
        'discussions-count' => ':count discussion|:count discussions',

        'locked' => 'Ce forum est verrouillé.',
    ],

    'discussions' => [
        'title' => 'Discussions',
        'title-create' => 'Créer une discussion',
        'title-edit' => 'Éditer une discussion',

        'pin' => 'Épingler cette discussion',
        'lock' => 'Verrouiller cette discussion',

        'respond' => 'Répondre',

        'locked' => 'Verrouillé',
        'pinned' => 'Épinglé',

        'info-locked' => 'Cette discussion est verrouillée.',

        'posts-count' => ':count message|:count messages',

        'delete' => 'Êtes-vous sûr de vouloir supprimer cette discussion ?',

        'status' => [
            'created' => 'La discussion a été créée.',
            'updated' => 'Cette discussion a été mise à jour.',
            'deleted' => 'Cette discussion a été supprimée.',

            'pinned' => 'Cette discussion a été épinglée.',
            'unpinned' => 'Cette discussion a été désépinglée.',
            'locked' => 'Cette discussion a été verrouillée.',
            'unlocked' => 'Cette discussion a été déverrouillée.',
        ],
    ],

    'posts' => [
        'title' => 'Messages',
        'title-edit' => 'Éditer le message',

        'delay' => 'Vous pouvez poster un nouveau message dans :time.',

        'delete' => 'Êtes-vous sûr de vouloir supprimer ce message ?',

        'status' => [
            'created' => 'Le message a été ajouté.',
            'updated' => 'Ce message a été mis à jour.',
            'deleted' => 'Ce message a été supprimé.',
        ],
    ],

    'notifications' => [
        'reply' => ':user a répondu à votre discussion :discussion',
        'mention' => ':user vous a mentionné dans :discussion',
    ],

    'profile' => [
        'likes' => 'J\'aimes',
        'posts' => 'Messages',
        'discussions' => 'Discussions',

        'information' => 'Informations',
        'edit' => 'Édition du profil',

        'location' => 'Localité',
        'website' => 'Site web',
        'about' => 'À propos',
        'signature' => 'Signature',
    ],
];
