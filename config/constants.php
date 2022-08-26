<?php

return [
    'roles' => [
        'add_point_vente' => 'Ajouter un nouveau point de vente',
        'view_point_vente' => 'Voir la liste de point de vente',
        'manage_roles_and_functions' => 'Gerer les personnels et les roles',
        'add_user' => 'Ajouter un nouveau personnel',
        'delete_user' => 'Supprimer un personnel',
        'view_user' => 'Voir la liste des utilisateur',
        'edit_user' => 'Modifier un personnel',
        'edit_point_vente' => 'Modifier un point de vente',
        'delete_point_vente' => 'Supprimer un point de vente',
        'add_entrepot' => 'Ajouter une nouvelle entrepôt',
        'view_entrepot' => 'Voir la liste des entrepôt',
        'edit_entrepot' => 'Modifier un entrepôt',
        'delete_entrepot' => 'Supprimer un entrepôt',
        'manage_settings' => 'Gerer les parametres de l\'entreprise',
    ],
    'fonctions' => [
        'Magasinier' => 'Responsable du magasin',
        'Vendeur' => 'Responsable de vente',
        'Directeur' => 'Responsable de tout',
    ],
    'fournisseurs' => [
        [
            "nom" => "RAKOTO Beloha",
            "adresse" => "Mangarano",
            "email" => "rakoto@gmail.com",
            "contact" => "032 54 123 43",
        ],
        [
            "nom" => "JEAN Paul",
            "adresse" => "Bazar be",
            "email" => "paul@gmail.com",
            "contact" => "032 54 123 44",
        ],
    ],
    'categories' => [
        "articles" => [
            [
                "libelle" => 'Matériel informatique',
                "description" => 'Tous ce qui est matériel informatique',
                "type" => 3,
            ],
            [
                "libelle" => 'Divers',
                "description" => 'Tous les autres artiles',
                "type" => 3,
            ],
        ],
    ],
    'articles' => [
        [
            'reference' => 'ART-0001',
            'designation' => 'Ordinateur',
            'unite' => 'Nombre',
            'description' => 'Ordinateur portable de marque ACER',
        ],
        [
            'reference' => 'ART-0002',
            'designation' => 'Souris',
            'unite' => 'Nombre',
            'description' => 'Souris de marque DELL',
        ],
    ],
];
