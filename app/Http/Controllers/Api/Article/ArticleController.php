<?php

namespace App\Http\Controllers\Api\Article;

use App\Models\Depot\Depot;
use Illuminate\Http\Request;
use App\Models\Article\Article;
use App\Models\Categorie\Categorie;
use App\Http\Controllers\Controller;
use App\Models\Article\DepotArticle;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use App\Http\Requests\Article\NouveauArticleRequest;
use App\Http\Requests\Article\ModifierArticleRequest;
use App\Models\Depot\DepotPrixArticle;

class ArticleController extends Controller
{
    /**
     * Recuperer la liste des articles
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $queries = $request->query();

        if ($queries !== []) {
            $article = $this->getDepotArticles(isset($queries["depot"]) ? Depot::find($queries["depot"]) : null, 'depot_articles.depot_id', false);
            $exclued_articles = [];
            foreach ($queries as $key => $value) {
                if ($key != 'depot') {
                    $article->where($key, 'LIKE', "%$value%");
                } else {
                    foreach ($article->get() as $key => $val) {
                        $art = Article::find($val->article_id);
                        if (
                            $art
                                ->depotPrixArticle(Depot::find($value), null)
                                ->get()
                                ->isEmpty()

                        ) {
                            $exclued_articles[] = $val->article_id;
                        }
                    }
                }
            }
            // dd($article->get()[0]["article"]);

            return $this->getResults(
                $article->whereNotIn('article_id', $exclued_articles)->get()
            );
        }

        return Article::query()->where("disabled", 0)->mapAll();
    }

    /**
     * Generer le resultat de recherche a afficher dans les vues
     *
     * @param Collection $articles Collection de depot articles
     * @return array Tableau de résultat
     */
    public function getResults(Collection $articles): array
    {
        $result = [];

        foreach ($articles as $a) {
            if ($a->detailsPrix !== null) {
                foreach ($a->detailsPrix as $p) {
                    $quantite = $p->quantite ?? 'Quantité restant';

                    if ($quantite !== '0.00') {
                        $result[] = [
                            'id' => $a->article_id,
                            'value' => $p->id,
                            'reference' => $a->reference,
                            'designation' => $a->designation,
                            'quantite' => $p->quantite,
                            'pu' => $p->pu,
                            'label' =>
                                $a->reference .
                                ' - ' .
                                $a->designation .
                                ' - ' .
                                $p->pu .
                                " ($quantite)",
                        ];
                    }
                }
            }
        }

        return $result;
    }

    /**
     * Enregistrer un nouvel article
     *
     * @param  \App\Http\Requests\Article\NouveauArticleRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(NouveauArticleRequest $request)
    {
        $data = $request->validated();

        $categories = $data['categories'];
        foreach ($data['sous_categories'] as $key => $value) $categories[] = $value;

        unset($data['categories']);
        unset($data['sous_categories']);

        $article = Article::create($data);

        foreach ($categories as $id) {
            $article->categories()->attach($id);
        }

        return $article;
    }

    /**
     * Voir un article spécifique
     *
     * @param  \App\Models\Article\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article)
    {
        $sousCategories = [];
        $sousCategoriesId = [];

        foreach ($article->categories as $categorie) {
            $sousCategories += $this->getSubCategories(
                $categorie
            );
            $sousCategoriesId += $this->getSubCategories(
                $categorie , true
            );
            $article->sc[$categorie->id] = $sousCategories;
        }


        // exclure les sous-categorie de la liste des categorie
        $categories = collect();
        $SousCategorie = collect();
        foreach ($article->categories as $key => $cat) {
            # code...
            $exist = false;
            foreach ($sousCategoriesId as $key_s => $sous) {
                # code...
                if($cat->id == $sous->id){
                    $exist = true;
                    $SousCategorie->push($cat);
                    $sousCategories[] = $cat->libelle;
                }
            }

            if(!$exist) $categories->push($cat);
        }
        $article["categories_reel"] = $categories;
        $article->sous_categories = $SousCategorie;

        return $article;
    }

    /**
     * Recuperer tous les sous catégories de la catégorie
     *
     * @param Categorie $categorie
     * @return array
     */
    public function getSubCategories(Categorie $categorie, $get = false): array
    {
        $return = [];

        foreach ($categorie->sousCategories as $sc) {
            $return[] = $get ? $sc : $sc->libelle;
            $return = array_merge($return, $this->getSubCategories($sc));
        }
        return $return;
    }

    /**
     * Mettre a jour un article
     *
     * @param  ModifierArticleRequest $request
     * @param  Article $article
     * @return Response
     */
    public function update(ModifierArticleRequest $request, Article $article)
    {
        $data = $request->validated();

        $categories = $data['categories'] ;
        foreach ($data['sous_categories'] as $key => $value) $categories[] = $value;

        unset($data['categories']);
        unset($data['sous_categories']);

        $article->update($data);

        $categoriesActuel = $article->categories->pluck('id');

        foreach ($categoriesActuel as $id) {
            $article->categories()->detach($id);
        }

        foreach ($categories as $id) {
            $article->categories()->attach($id);
        }

        return response()->json(['success' => 'Modifié avec succès']);
    }

    /**
     * Supprimer un article de la base de données
     *
     * @param  \App\Models\Article\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function destroy(Article $article)
    {
        // verifier  d'abord si il n'y est pas utiliser par d'autre table
        $bons = $article->bons;
        $commande = $article->commandes;
        $price = DepotPrixArticle::where("article", $article->id)->get();
        $stock = DepotArticle::where("article_id", $article->id)->get();

        if($bons->isEmpty() && $commande->isEmpty() && $price->isEmpty() && $stock->isEmpty()){
            $article->categories()->detach();
            $article->delete();
        }else{
            $article->disabled = true;
            $article->update();
        }
        return response()->json(['success' => 'Supprimé avec succès']);
    }

    /**
     * Permet de recuperer tous les articles dans un dépot
     * Avec un calcul de stock d'entrée moins stock de sortie (Entree - Sortie)
     *
     * @param Request $request
     * @param Depot $depot
     * @return Response
     */
    public function articles(Request $request, Depot $depot)
    {
        $limit = intval($request->limit);
        $articleId = intval($request->article_id);

        $depotArticle = $this->getDepotArticles($depot);
        if ($articleId > 0) {
            $depotArticle = $depotArticle->get();
            $depotArticle = $depotArticle
                ->where('article_id', $articleId)
                ->first(); // Si on ne veut qu'un seul article en particulier
            return $depotArticle;
        }
        if ($limit === 0) {

            return $this->availableStock($depotArticle->get()->toArray());
        }

        return $this->availableStock($depotArticle->take($limit)->get()->toArray());

    }

    public function availableStock($articles){
        $res  = [];
        $articles = array_filter($articles, function ($art) {
            $entree = $art["entree"] != null ? floatval($art["entree"]) : 0;
            $sortie = $art["sortie"] != null ? floatval($art["sortie"]) : 0;

            return ($entree - $sortie) > 0;
        });

        foreach($articles as $article){
            $res[] = $article;
        }

        return $res;
    }

    /**
     * Recupere tous les articles d'un dépot ou tous les dépots articles
     *
     * @param Depot|null $depot Le depot concerné
     * @return Builder
     */
    public function getDepotArticles(?Depot $depot = null, ?string $by = null, $disabled = null)
    {
        // $depotArticle = DepotArticle::query()
        //     ->selectRaw("articles.id as article_id")
        //     ->selectRaw("(select art.reference from articles as art where art.id = articles.id LIMIT 1) as reference")
        //     ->selectRaw("(select art.designation from articles as art where art.id = articles.id LIMIT 1) as designation")
        //     ->selectRaw("(select art.unite from articles as art where art.id = articles.id LIMIT 1) as unite")
        //     ->selectRaw("(select dep.depot_id from depot_articles as dep where dep.article_id = articles.id LIMIT 1) as depot_id")
        //     ->selectRaw("(select dep.bon from depot_articles as dep where dep.article_id = articles.id LIMIT 1) as bon")
        //     ->selectRaw("SUM(CASE WHEN depot_articles.type = 1 THEN quantite END) as entree")
        //     ->selectRaw("SUM(CASE WHEN depot_articles.type = 0 THEN quantite END) as sortie")
        //     ->rightJoin('articles', 'articles.id', '=', 'depot_articles.article_id');

        //     if ($depot !== null) $depotArticle->where('depot_id', $depot->id)->orWhere('depot_id', null);
        //     $depotArticle->groupBy(['articles.id']);
        //     if ($by !== null) $depotArticle->groupBy($by);

        // return $depotArticle;

        return DepotArticle::getDepotArticles($depot, $by, $disabled);
    }

    /**
     * Recupere la liste des aritcle dans un depôt avec les prix de vent s'il en existe
     */

    public function articlePrixVente(Depot $depot = null)
    {
        $articles = DepotArticle::where('depot_id', $depot->id)
            ->groupBy('article_id')
            ->get('article_id');

        $res = $articles->map(function ($el, $key) use ($depot) {
            $article = Article::find($el->article_id);
            return [
                'article' => $article,
                'prix' => $article->depotPrixArticle($depot)->get(),
            ];
        });

        return $res;
    }

    /**
     *  Recuperer la liste des dépôts avec le stock de l'article voulue respectivement
     */

     public function voirParDepot(Article $article){
        return Depot::mapStockArticleParDepot($article);
     }
}
