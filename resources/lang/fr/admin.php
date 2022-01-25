<?php

return [

    'nav' => [
        'settings' => 'Paramètres',
        'forums' => 'Forums',
        'tags' => 'Étiquettes',
    ],

    'settings' => [
        'title' => 'Paramètres du forum',
    ],

    'categories' => [
        'title' => 'Catégories',
        'title-edit' => 'Éditer la catégorie #:category',
        'title-create' => 'Créer une catégorie',

        'status' => [
            'created' => 'La catégorie a été créée.',
            'updated' => 'Cette catégorie a été mise à jour.',
            'deleted' => 'Cette catégorie a été supprimée.',

            'error-delete' => 'La catégorie contient des forums et ne peut pas être supprimée.',
        ],
    ],

    'forums' => [
        'title' => 'Forums',
        'title-create' => 'Créer un forum',
        'title-edit' => 'Éditer le forum :forum',

        'create-category' => 'Créer une catégorie',
        'create-forum' => 'Créer un forum',

        'icons' => 'Vous pouvez avoir la liste des icônes disponibles sur <a href="https://fontawesome.com/icons?d=gallery&m=free" target="_blank" rel="noopener noreferrer">FontAwesome</a>.',

        'restricted' => 'Restreindre l\'accès à ce forum à certains grades seulement',
        'default_tags' => 'Tags par défaut',

        'lock' => 'Verrouiller ce forum',
        'lock-info' => 'Les utilisateurs qui ne sont pas admin ne pourront pas créer de discussions.',

        'status' => [
            'created' => 'Le forum a été créé.',
            'updated' => 'Ce forum a été mis à jour.',
            'deleted' => 'Ce forum a été supprimé.',

            'order-updated' => 'Ordre des forums mis à jour.',

            'error-delete' => 'Ce forum contient des discussions et ne peut pas être supprimée.',
            'delete-with-forums' => 'Un forum qui contient des sous-forums ne peut pas être supprimé.',
        ],
    ],

    'discussions' => [
        'card' => 'Discussions sur forum',
    ],

    'posts' => [
        'card' => 'Messages sur le forum',

        'delay' => 'Délai entre chaque messages',
        'seconds' => 'secondes',
    ],

    'tags' => [
        'title' => 'Étiquettes',
        'create' => 'Créer une étiquette',
    ],

    'logs' => [
        'forum-discussions' => [
            'deleted' => 'Suppression de la discussion #:id',
            'pinned' => 'Ajout de la discussion #:id en épinglé',
            'unpinned' => 'Retrait de la discussion #:id des épinglées',
            'locked' => 'Verrouillage de la discussion #:id',
            'unlocked' => 'Déverrouillage de la discussion #:id',
        ],

        'forum-posts' => [
            'deleted' => 'Suppression du message #:id',
        ],

        'forum-categories' => [
            'created' => 'Création de la catégorie forum #:id',
            'updated' => 'Mise à jour de la catégorie forum #:id',
            'deleted' => 'Suppression de la catégorie forum #:id',
        ],

        'forum-forums' => [
            'created' => 'Création du forum #:id',
            'updated' => 'Mise à jour du forum #:id',
            'deleted' => 'Suppression du forum #:id',
        ],
    ],

    'permissions' => [
        'forums' => 'Gérer les forums et les catégories',
        'discussions' => 'Gérer les discussions du forum',
        'delete-self-post' => 'Supprimer ses propres messages du forum',
    ],
];
