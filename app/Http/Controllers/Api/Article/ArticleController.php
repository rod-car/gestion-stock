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

        if ($queries !== [])
        {
            $article = $this->getDepotArticles(null, 'depot_articles.depot_id');

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
     * Enregistrer un nouveau article
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
     * Voir un article spécifique
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
     * Mettre a jour un article
     *
     * @param  ModifierArticleRequest $request
     * @param  Article $article
     * @return Response
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
     * Supprimer un article de la base de données
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


    /**
     * Recupere tous les articles d'un dépot ou tous les dépots articles
     *
     * @param Depot|null $depot Le depot concerné
     * @return Builder
     */
    public function getDepotArticles(?Depot $depot = null, ?string $by = null)
    {
        $depotArticle = DepotArticle::query()
            ->selectRaw("articles.id as article_id")
            ->selectRaw("(select art.reference from articles as art where art.id = articles.id LIMIT 1) as reference")
            ->selectRaw("(select art.designation from articles as art where art.id = articles.id LIMIT 1) as designation")
            ->selectRaw("(select art.unite from articles as art where art.id = articles.id LIMIT 1) as unite")
            ->selectRaw("(select dep.depot_id from depot_articles as dep where dep.article_id = articles.id LIMIT 1) as depot_id")
            ->selectRaw("(select dep.bon from depot_articles as dep where dep.article_id = articles.id LIMIT 1) as bon")
            ->selectRaw("SUM(CASE WHEN depot_articles.type = 1 THEN quantite END) as entree")
            ->selectRaw("SUM(CASE WHEN depot_articles.type = 0 THEN quantite END) as sortie")
            ->rightJoin('articles', 'articles.id', '=', 'depot_articles.article_id');


            if ($depot !== null) $depotArticle->where('depot_id', $depot->id)->orWhere('depot_id', null);
            $depotArticle->groupBy(['articles.id']);
            if ($by !== null) $depotArticle->groupBy($by);

        return $depotArticle;
    }
}
