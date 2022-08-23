<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models\Article{
/**
 * App\Models\Article\Article
 *
 * @property int $id
 * @property string $reference
 * @property string|null $designation
 * @property string $unite
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $stock_alert Quantité en stock restant pour alerter l'utilisateur pour un appro
 * @property-read \Illuminate\Database\Eloquent\Collection|Categorie[] $categories
 * @property-read int|null $categories_count
 * @property-read array $sc
 * @method static \Database\Factories\Article\ArticleFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Article newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Article newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Article query()
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereDesignation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereReference($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereStockAlert($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereUnite($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class Article extends \Eloquent {}
}

namespace App\Models\Article{
/**
 * App\Models\Article\Commande
 *
 * @property int $id
 * @property string $numero
 * @property int $type Type de commande: 1 - Dévis, 2 - Commande proprement dit
 * @property string $date
 * @property int|null $validite Validité du dévis en nombre de jour
 * @property int|null $fournisseur
 * @property int|null $client
 * @property Commande|null $devis Devis dans laquelle provient ce commande. N'est utile que pour les commandes
 * @property int $status Status du dévis: 1 - Valide
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $adresse_livraison Adresse de livraison des marchandises dans lecas d'une commande
 * @property string|null $file_path
 * @property-read \Illuminate\Database\Eloquent\Collection|Article[] $articles
 * @property-read int|null $articles_count
 * @property-read Client|null $cl
 * @property-read Fournisseur|null $frs
 * @property-read string $date_expiration
 * @property-read bool $expire
 * @property-read bool $recu
 * @method static \Illuminate\Database\Eloquent\Builder|Commande newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Commande newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Commande query()
 * @method static \Illuminate\Database\Eloquent\Builder|Commande whereAdresseLivraison($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Commande whereClient($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Commande whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Commande whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Commande whereDevis($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Commande whereFilePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Commande whereFournisseur($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Commande whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Commande whereNumero($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Commande whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Commande whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Commande whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Commande whereValidite($value)
 * @mixin \Eloquent
 */
	class Commande extends \Eloquent {}
}

namespace App\Models\Article{
/**
 * App\Models\Article\DepotArticle
 *
 * @property int $id
 * @property int $article_id Id de l'artile a stocker
 * @property string $quantite Quantité de l'article dans la bon de reception
 * @property int $responsable Id du responsable qui a fait entrer le stock
 * @property int $bon Bon de livraison ou bon de reception qui contient l'article
 * @property int $depot_id Identifiant du point de vente ou entrepot pour stocker l'article
 * @property int|null $provenance_id Identifiant du point de vente ou entrepot où provient l'article. Uniquement utilisé dans le cadre d'un transfert. null si l'article provient d'un fournisseur
 * @property int|null $destination_id Identifiant du point de vente ou entrepot où on doit deplacer l'article. Uniquement utilisé dans le cadre d'un transfert.
 * @property string $date_transaction
 * @property int $type Type de transaction. Entrée en stock ou sortie de stock. 1: Entree, 0: Sortie
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Article\Article $article
 * @property-read \App\Models\Depot\Depot $depot
 * @property-read mixed $details_prix
 * @property-read \App\Models\Article\Article $full_article
 * @method static \Illuminate\Database\Eloquent\Builder|DepotArticle newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DepotArticle newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DepotArticle query()
 * @method static \Illuminate\Database\Eloquent\Builder|DepotArticle whereArticleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DepotArticle whereBon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DepotArticle whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DepotArticle whereDateTransaction($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DepotArticle whereDepotId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DepotArticle whereDestinationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DepotArticle whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DepotArticle whereProvenanceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DepotArticle whereQuantite($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DepotArticle whereResponsable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DepotArticle whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DepotArticle whereUpdatedAt($value)
 */
	class DepotArticle extends \Eloquent {}
}

namespace App\Models\Bon{
/**
 * App\Models\Bon\BonReception
 *
 * @property int $id
 * @property string $numero
 * @property string $date
 * @property int|null $commande
 * @property int $status Status de bon de reception
 * @property string|null $adresse_livraison Adresse de livraison des marchandises
 * @property string|null $livreur Nom du livreur de la marchandise
 * @property string|null $contact_livreur Contact du livreur
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|Article[] $articles
 * @property-read int|null $articles_count
 * @method static \Illuminate\Database\Eloquent\Builder|BonReception newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BonReception newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BonReception query()
 * @method static \Illuminate\Database\Eloquent\Builder|BonReception whereAdresseLivraison($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BonReception whereCommande($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BonReception whereContactLivreur($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BonReception whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BonReception whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BonReception whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BonReception whereLivreur($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BonReception whereNumero($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BonReception whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BonReception whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class BonReception extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\CategorieArticle
 *
 * @method static \Illuminate\Database\Eloquent\Builder|CategorieArticle newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CategorieArticle newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CategorieArticle query()
 * @mixin \Eloquent
 */
	class CategorieArticle extends \Eloquent {}
}

namespace App\Models\Categorie{
/**
 * App\Models\Categorie\Categorie
 *
 * @property int $id
 * @property string $libelle
 * @property string|null $description
 * @property int $type Type de la catégorie: 1-Client, 2-Article, 3-Frs
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|Categorie[] $parentCategories
 * @property-read int|null $parent_categories_count
 * @property-read \Illuminate\Database\Eloquent\Collection|Categorie[] $sousCategories
 * @property-read int|null $sous_categories_count
 * @method static \Illuminate\Database\Eloquent\Builder|Categorie newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Categorie newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Categorie query()
 * @method static \Illuminate\Database\Eloquent\Builder|Categorie whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Categorie whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Categorie whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Categorie whereLibelle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Categorie whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Categorie whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class Categorie extends \Eloquent {}
}

namespace App\Models\Client{
/**
 * App\Models\Client\Client
 *
 * @property int $id
 * @property string $nom Nom de la personne ou nom d'une entreprise
 * @property string $adresse
 * @property string|null $email
 * @property string $contact
 * @property string|null $nif
 * @property string|null $cif
 * @property string|null $stat
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|Categorie[] $categories
 * @property-read int|null $categories_count
 * @method static \Illuminate\Database\Eloquent\Builder|Client newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Client newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Client query()
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereAdresse($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereCif($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereContact($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereNif($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereNom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereStat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class Client extends \Eloquent {}
}

namespace App\Models\Depot{
/**
 * App\Models\Depot\Depot
 *
 * @property int $id
 * @property string $nom
 * @property string|null $contact Contact du responsable
 * @property string $localisation
 * @property int $point_vente Permet de savoir si un depot est un entrepôt ou un point de vente
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|Article[] $articles
 * @property-read int|null $articles_count
 * @property-read \Illuminate\Database\Eloquent\Collection|User[] $responsables
 * @property-read int|null $responsables_count
 * @property-read \Illuminate\Database\Eloquent\Collection|User[] $travailleurs
 * @property-read int|null $travailleurs_count
 * @method static \Illuminate\Database\Eloquent\Builder|Depot newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Depot newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Depot query()
 * @method static \Illuminate\Database\Eloquent\Builder|Depot whereContact($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Depot whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Depot whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Depot whereLocalisation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Depot whereNom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Depot wherePointVente($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Depot whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class Depot extends \Eloquent {}
}

namespace App\Models\Depot{
/**
 * App\Models\Depot\DepotPrixArticle
 *
 * @property int $id
 * @property int $article
 * @property int $depot
 * @property string|null $quantite Null si tous les autres articles sont concerné par le prix
 * @property string $pu
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|DepotPrixArticle newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DepotPrixArticle newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DepotPrixArticle query()
 * @method static \Illuminate\Database\Eloquent\Builder|DepotPrixArticle whereArticle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DepotPrixArticle whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DepotPrixArticle whereDepot($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DepotPrixArticle whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DepotPrixArticle wherePu($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DepotPrixArticle whereQuantite($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DepotPrixArticle whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class DepotPrixArticle extends \Eloquent {}
}

namespace App\Models\Depot{
/**
 * App\Models\Depot\Travailler
 *
 * @property int $personnel
 * @property int $depot
 * @property bool $est_responsable Permet de determiner si le personnel est responsable de ce depot
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Travailler newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Travailler newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Travailler query()
 * @method static \Illuminate\Database\Eloquent\Builder|Travailler whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Travailler whereDepot($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Travailler whereEstResponsable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Travailler wherePersonnel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Travailler whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class Travailler extends \Eloquent {}
}

namespace App\Models\Fournisseur{
/**
 * App\Models\Fournisseur\Fournisseur
 *
 * @property int $id
 * @property string $nom Nom de la personne ou nom d'une entreprise
 * @property string $adresse
 * @property string|null $email
 * @property string $contact
 * @property string|null $nif
 * @property string|null $cif
 * @property string|null $stat
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|Categorie[] $categories
 * @property-read int|null $categories_count
 * @method static \Illuminate\Database\Eloquent\Builder|Fournisseur newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Fournisseur newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Fournisseur query()
 * @method static \Illuminate\Database\Eloquent\Builder|Fournisseur whereAdresse($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Fournisseur whereCif($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Fournisseur whereContact($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Fournisseur whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Fournisseur whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Fournisseur whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Fournisseur whereNif($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Fournisseur whereNom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Fournisseur whereStat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Fournisseur whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class Fournisseur extends \Eloquent {}
}

namespace App\Models\Parametres{
/**
 * App\Models\Parametres\Parametre
 *
 * @property int $id
 * @property array|null $generale
 * @property string|null $devise
 * @method static \Illuminate\Database\Eloquent\Builder|Parametre newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Parametre newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Parametre query()
 * @method static \Illuminate\Database\Eloquent\Builder|Parametre whereDevise($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Parametre whereGenerale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Parametre whereId($value)
 * @mixin \Eloquent
 */
	class Parametre extends \Eloquent {}
}

namespace App\Models\Personnel{
/**
 * Model permettant de representer les fonctions dans l'application
 *
 * @property int $id
 * @property string $nom_fonction
 * @property string|null $description_fonction
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read Collection|Fonction[] $enfants
 * @property-read int|null $enfants_count
 * @property-read Collection $fonctions_inclus_ids
 * @property-read Collection $permission_ids
 * @property-read Collection|Role[] $permissions
 * @property-read int|null $permissions_count
 * @property-read Collection|User[] $personnelles
 * @property-read int|null $personnelles_count
 * @method static \Illuminate\Database\Eloquent\Builder|Fonction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Fonction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Fonction query()
 * @method static \Illuminate\Database\Eloquent\Builder|Fonction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Fonction whereDescriptionFonction($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Fonction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Fonction whereNomFonction($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Fonction whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class Fonction extends \Eloquent {}
}

namespace App\Models\Personnel{
/**
 * App\Models\Personnel\FonctionInclusion
 *
 * @property int $fonction_parent
 * @property int $fonction_enfant
 * @method static \Illuminate\Database\Eloquent\Builder|FonctionInclusion newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FonctionInclusion newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FonctionInclusion query()
 * @method static \Illuminate\Database\Eloquent\Builder|FonctionInclusion whereFonctionEnfant($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FonctionInclusion whereFonctionParent($value)
 * @mixin \Eloquent
 */
	class FonctionInclusion extends \Eloquent {}
}

namespace App\Models\Personnel{
/**
 * App\Models\Personnel\FonctionRole
 *
 * @property int $fonction
 * @property int $role
 * @method static \Illuminate\Database\Eloquent\Builder|FonctionRole newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FonctionRole newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FonctionRole query()
 * @method static \Illuminate\Database\Eloquent\Builder|FonctionRole whereFonction($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FonctionRole whereRole($value)
 * @mixin \Eloquent
 */
	class FonctionRole extends \Eloquent {}
}

namespace App\Models\Personnel{
/**
 * App\Models\Personnel\PersonnelFonction
 *
 * @property int $personnel
 * @property int $fonction
 * @property string|null $date_association
 * @method static \Illuminate\Database\Eloquent\Builder|PersonnelFonction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PersonnelFonction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PersonnelFonction query()
 * @method static \Illuminate\Database\Eloquent\Builder|PersonnelFonction whereDateAssociation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PersonnelFonction whereFonction($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PersonnelFonction wherePersonnel($value)
 * @mixin \Eloquent
 */
	class PersonnelFonction extends \Eloquent {}
}

namespace App\Models\Role{
/**
 * App\Models\Role\Role
 *
 * @property int $id
 * @property string $nom_role
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $description
 * @method static \Database\Factories\Role\RoleFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Role newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Role newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Role query()
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereNomRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class Role extends \Eloquent {}
}

namespace App\Models\Role{
/**
 * App\Models\Role\UserRole
 *
 * @property int $user_id
 * @property int $role_id
 * @method static \Illuminate\Database\Eloquent\Builder|UserRole newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserRole newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserRole query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserRole whereRoleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserRole whereUserId($value)
 * @mixin \Eloquent
 */
	class UserRole extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property int $id
 * @property string $nom_personnel
 * @property string|null $prenoms_personnel
 * @property string $contact_personnel
 * @property string $adresse_personnel
 * @property string|null $cin_personnel
 * @property string|null $username
 * @property string|null $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string|null $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|Fonction[] $fonctions
 * @property-read int|null $fonctions_count
 * @property-read \App\Models\Collection $nom_complet
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|Role[] $roles
 * @property-read int|null $roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Sanctum\PersonalAccessToken[] $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\UserFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereAdressePersonnel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCinPersonnel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereContactPersonnel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereNomPersonnel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePrenomsPersonnel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUsername($value)
 * @mixin \Eloquent
 */
	class User extends \Eloquent {}
}

