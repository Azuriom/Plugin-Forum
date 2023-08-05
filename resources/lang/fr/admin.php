<?php

return [

    'nav' => [
        'settings' => 'Paramètres',
        'forums' => 'Forums',
        'tags' => 'Étiquettes',
    ],

    'settings' => [
        'title' => 'Paramètres du forum',
        'home_message' => 'Message de la page d\'accueil',
        'webhook' => 'URL de webhook Discord',
        'webhook_info' => 'Une notification sur ce webhook sera envoyée lorsqu\'un nouveau message est posté. Laissez vide pour ne pas utiliser de webhook.',
    ],

    'categories' => [
        'title' => 'Catégories',
        'edit' => 'Éditer la catégorie #:category',
        'create' => 'Créer une catégorie',

        'delete_error' => 'La catégorie contient des forums et ne peut pas être supprimée.',
    ],

    'forums' => [
        'title' => 'Forums',
        'create' => 'Créer un forum',
        'edit' => 'Éditer le forum :forum',

        'create_category' => 'Créer une catégorie',
        'create_forum' => 'Créer un forum',

        'parent' => 'Forum parent',
        'restricted' => 'Restreindre l\'accès à ce forum à certains grades seulement',
        'default_tags' => 'Tags par défaut',
        'lock' => 'Verrouiller ce forum',
        'lock_info' => 'Les utilisateurs qui ne sont pas admin ne pourront pas créer de discussions.',
        'private' => 'Forum privé',
        'private_info' => 'Les utilisateurs ne peuvent voir que leurs propres discussions et celles épinglées.',

        'updated' => 'Ordre des forums mis à jour.',
        'delete_error' => 'Un forum qui contient des discussions ou des sous-forums ne peut pas être supprimé',
    ],

    'discussions' => [
        'card' => 'Discussions sur le forum',
    ],

    'posts' => [
        'card' => 'Messages sur le forum',

        'recent' => 'Messages récents à l\'accueil',
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
        'private' => 'Voir les discussions des autres utilisateurs dans les forums privés',
        'delete_own_posts' => 'Supprimer ses propres messages du forum',
        'locked' => 'Créer une discussion dans un forum verrouillé',
    ],
];
