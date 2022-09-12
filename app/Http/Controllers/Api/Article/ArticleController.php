<?php

namespace App\Http\Controllers\Api\Article;

use Response;
use App\Models\Depot\Depot;
use Illuminate\Http\Request;
use App\Models\Article\Article;
use App\Models\Categorie\Categorie;
use App\Http\Controllers\Controller;
use App\Models\Article\DepotArticle;
use Illuminate\Database\Eloquent\Collection;
use App\Http\Requests\Article\NouveauArticleRequest;
use App\Http\Requests\Article\ModifierArticleRequest;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $queries = $request->query();

        if ($queries !== [])
        {
            $article = $this->getDepotArticles();

            foreach ($queries as $key => $value)
            {
                $article->where($key, 'LIKE', "%$value%");
            }

            return $this->getResults($article->get());
        }

        return Article::all();
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

        foreach ($articles as $a)
        {
            if ($a->detailsPrix !== null)
            {
                foreach ($a->detailsPrix as $p)
                {
                    $quantite = $p->quantite ?? "Quantité restant";

                    if ($quantite !== "0.00")
                    {
                        $result[] = [
                            'id' => $a->article_id,
                            'value' => $p->id,
                            'reference' => $a->reference,
                            'designation' => $a->designation,
                            'quantite' => $p->quantite,
                            'pu' => $p->pu,
                            'label' => $a->reference . " - " . $a->designation . " - " . $p->pu . " ($quantite)",
                        ];
                    }
                }
            }
        }

        return $result;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Article\NouveauArticleRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(NouveauArticleRequest $request)
    {
        $data = $request->validated();
        $categories = $data["categories"];
        unset($data["categories"]);

        $article = Article::create($data);

        foreach ($categories as $id) {
            $article->categories()->attach($id);
        }

        return $article;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Article\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article)
    {
        $sousCategories = [];
        foreach ($article->categories as $categorie) {
            $sousCategories[$categorie->id] = $this->getSubCategories($categorie);
        }
        $article->sc = $sousCategories;
        return $article;
    }


    /**
     * Recuperer tous les sous catégories de la catégorie
     *
     * @param Categorie $categorie
     * @return array
     */
    public function getSubCategories(Categorie $categorie): array
    {
        $return = [];

        foreach ($categorie->sousCategories as $sc) {
            $return[] = $sc->libelle;
            $return = array_merge($return, $this->getSubCategories($sc));
        }
        return $return;
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Http\Requests\Article\ModifierArticleRequest  $article
     * @return \Illuminate\Http\Response
     */
    public function update(ModifierArticleRequest $request, Article $article)
    {
        $data = $request->validated();
        $categories = $data["categories"];

        unset($data["categories"]);

        $article->update($data);

        $categoriesActuel = $article->categories->pluck('id');

        foreach ($categoriesActuel as $id) {
            if (!in_array($id, $categories)) $article->categories()->detach($id);
        }

        foreach ($categories as $id) {
            if (!$article->categories->contains($id)) $article->categories()->attach($id);
        }

        return response()->json(["success" => "Modifié avec succès"]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Article\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function destroy(Article $article)
    {
        $article->categories()->detach();
        $article->delete();
        return response()->json(["success" => "Supprimé avec succès"]);
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
            $depotArticle = $depotArticle->where('article_id', $articleId)->first(); // Si on ne veut qu'un seul article en particulier
            return $depotArticle;
        }

        if ($limit === 0) return $depotArticle->get();
        return $depotArticle->take($limit)->get();
    }

    public function getDepotArticles(?Depot $depot = null)
    {
        $depotArticle = DepotArticle::query()
            ->selectRaw("ANY_VALUE(articles.reference) as reference")
            ->selectRaw("ANY_VALUE(articles.designation) as designation")
            ->selectRaw("ANY_VALUE(articles.unite) as unite")
            ->selectRaw("ANY_VALUE(articles.id) as article_id")
            ->selectRaw("ANY_VALUE(depot_articles.depot_id) as depot_id")
            ->selectRaw("ANY_VALUE(depot_articles.bon) as bon")
            ->selectRaw("SUM(CASE WHEN depot_articles.type = 1 THEN quantite END) as entree")
            ->selectRaw("SUM(CASE WHEN depot_articles.type = 0 THEN quantite END) as sortie")
            ->rightJoin('articles', 'articles.id', '=', 'depot_articles.article_id');

        if ($depot !== null) $depotArticle->where('depot_id', $depot->id)->orWhere('depot_id', null);
        return $depotArticle->groupBy(['articles.id']);
    }
}
