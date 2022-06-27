<?php

namespace App\Http\Controllers\Api\Article;

use Illuminate\Http\Request;
use App\Models\Article\Article;
use App\Http\Controllers\Controller;
use App\Http\Requests\Article\NouveauArticleRequest;
use App\Http\Requests\Article\ModifierArticleRequest;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Article::all();
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
        return $article;
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
}
