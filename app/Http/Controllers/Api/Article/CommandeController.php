<?php

namespace App\Http\Controllers\Api\Article;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Article\Commande;
use Illuminate\Http\UploadedFile;
use App\Http\Controllers\Controller;
use App\Models\Depot\DepotPrixArticle;
use Illuminate\Database\Eloquent\Collection;
use App\Http\Requests\Commande\NouveauCommandeRequest;
use App\Http\Requests\Commande\ModifierCommandeRequest;

class CommandeController extends Controller
{
    /**
    * Display a listing of the orders or quotations.
    *
    * @return \Illuminate\Http\Response
    */
    public function index(Request $request)
    {
        $type = intval($request->type); // Detecter si c'est un dévis ou une commande
        $appro = $request->boolean('appro'); // Determine si un dévis est un approvisionnement ou non (Si non: Vente)

        $commandes = Commande::where('type', $type);

        if ($appro) {
            $commandes = $commandes->where('fournisseur', '<>', null);
        } else {
            $commandes = $commandes->where('client', '<>', null);
        }

        if ($type === 2) $this->updateCommandeStatus($commandes->get()); // Si c'est une commande
        return response()->json($commandes->get());
    }


    /**
    * Permet de mettre a jour le status d'une ommande si tous les articles sont déja livré
    *
    * @param Collection $commandes
    * @return void
    */
    public function updateCommandeStatus(Collection $commandes)
    {
        $commandes = $commandes->where('status', 1);
        foreach ($commandes as $commande) {
            if ($commande->recu === true and $commande->status === 1) {
                $commande->status = 3;
                $commande->save();
            }
        }
    }

    /**
    * Store a newly created order or quotation in storage.
    *
    * @param  App\Http\Requests\Commande\NouveauCommandeRequest  $request
    * @return \Illuminate\Http\Response
    */
    public function store(NouveauCommandeRequest $request)
    {
        $data = $request->validated();

        if (key_exists('file', $data)) $file = $data['file'];
        else $file = null;

        $articles = $data['articles'];

        if (!$this->checkArticleQuantite($articles)) {
            return response()->json([
                "errors" => ["quantite" => ["Quantité n'est pas valide"]],
                "message" => "Les quantités d'articles ne sont pas valide"
            ], 422);
        }

        $commande = Commande::create($data);

        if ($file !== null) $this->updateFile($commande, $file);
        $this->updateArticle($commande, $articles);

        return $commande;
    }

    /**
    * Display the specified order or quotation.
    *
    * @param  \App\Models\Article\Commande  $commande
    * @return \Illuminate\Http\Response
    */
    public function show(Commande $commande)
    {
        return $commande;
    }

    /**
     * Update the specified order or quotation in storage.
     *
     * @param  ModifierCommandeRequest  $request
     * @param  \App\Models\Article\Commande  $commande
     * @return \Illuminate\Http\Response
     */
    public function update(ModifierCommandeRequest $request, Commande $commande)
    {
        $data = $request->validated();
        $articles = $data['articles'];
        $file = key_exists('file', $data) ? $data['file'] : null;
        $commande->update($data);

        if ($file !== null) $this->updateFile($commande, $file);
        $this->updateArticle($commande, $articles, true);

        return $data;
    }

    /**
    * Remove the specified order or quotation from storage.
    *
    * @param  \App\Models\Article\Commande  $commande
    * @return \Illuminate\Http\Response
    */
    public function destroy(Commande $commande)
    {
        $commande->articles()->detach();
        $commande->delete();

        return response()->json([
            "success" => "Supprimé avec succès"
        ]);
    }


    /**
    * Mettre a jour les articles associé a un commande
    *
    * @param Commande $commande La commande en question
    * @param array $articles Les articles concerné
    * @return bool
    */
    public function updateArticle(Commande $commande, array $articles, bool $update = false): bool
    {
        $articlesActuel = $commande->articles->pluck('id')->toArray();

        foreach ($articlesActuel as $id) {
            if (!in_array($id, collect($articles)->pluck('id')->toArray())) {
                $commande->articles()->detach($id);
            }
        }

        foreach ($articles as $article) {
            $data = [
                'pu' => $article['pu'],
                'quantite' => $article['quantite'],
                'tva' => $article['tva'],
            ];

            // Mettre a jour la quantité restant de l'article qui est d'un prix spécifique spécifique quan on fait une commande
            if (key_exists('object', $article) AND $article['object'] !== null AND intval($commande->type) === 2)
            {
                $data['reference_id'] = $article['object']['value'];

                $depotPrixArticle = DepotPrixArticle::findOrFail($article['object']['value']);
                if ($depotPrixArticle->quantite !== null)
                {
                    $nouveauQuantite = 0;

                    $quantiteRestant = doubleval($depotPrixArticle->quantite); // Quantite au prix unitaire ce prix demandé

                    if ($update)
                    {
                        $commandeArticle = $commande->getArticle($article['id']);

                        $quantiteDeduire = doubleval($article["quantite"]); // Nouvelle quantité a mettre a jour
                        $quantiteCommande = doubleval($commandeArticle->pivot->quantite - $commandeArticle->pivot->quantite_recu); // Quantité total non livré de la commande

                        if ($quantiteDeduire > $quantiteCommande)
                        {
                            // Si la nouvelle quantité est supérieur a celle qui es déja renseigné avant
                            $diffQuantite = $quantiteDeduire - $quantiteCommande;
                            $nouveauQuantite = $quantiteRestant - $diffQuantite;
                        }
                        elseif ($quantiteDeduire < $quantiteCommande)
                        {
                            // Si la novelle quantité est inferieur a celle qui est déja renseigné avant
                            $diffQuantite = $quantiteCommande - $quantiteDeduire;
                            $nouveauQuantite = $quantiteRestant + $diffQuantite;
                        }
                        else
                        {
                            $nouveauQuantite = $quantiteRestant;
                        }
                    }
                    else
                    {
                        $nouveauQuantite = $quantiteRestant - $article['quantite'];
                    }

                    $depotPrixArticle->quantite = $nouveauQuantite;
                    $depotPrixArticle->save();
                }
            }

            if ($commande->articles->contains($article["id"]))
            {
                $commande->articles()->updateExistingPivot($article["id"], $data);
            }
            else
            {
                $commande->articles()->attach($article['id'], $data);
            }
        }

        return true;
    }


    /**
     * Verifier si la quantité des articles demandés est suffisant en stock
     *
     * @param array $articles Tableau des articles
     * @return boolean
     */
    public function checkArticleQuantite(array $articles): bool
    {
        $errors = [];

        foreach ($articles as $article)
        {
            if (key_exists('object', $article) AND $article['object'] !== null)
            {
                $quantite = floatval($article['quantite']);
                $totalQuantite = floatval($article['object']['quantite']); // Donne 0 si la quantite est tous les quantité restant

                if ($totalQuantite !== 0.0 AND $quantite > $totalQuantite)
                {
                    $errors[] = false;
                }
            }
        }

        if (count($errors) > 0) return false;
        return true;
    }

    /**
    * Recuperer le dernier dernier devis
    *
    * @param Request $request
    * @return Response
    */
    public function getKey(Request $request)
    {
        $appro = $request->boolean('appro'); // Determine si un dévis est un approvisionnement ou non (Si non: Vente)
        switch (intval($request->type)) {
            case 1:
                return response()->json(["key" => reference(1, $appro, "D")]);
                break;

            case 2:
                return response()->json(["key" => reference(2, $appro, "BC")]);
                break;

            case 3:
                return response()->json(["key" => reference(3, null, "BR")]);
                break;

            case 4:
                return response()->json(["key" => reference(4, null, "BL")]);
                break;

            default:
                throw new Exception("Type qui n'est pas une type de commande... Type: {$request->type}");
                break;
        }
    }


    /**
     * Mettre a jour la pièce jointe associé a la commande
     *
     * @param Commande $commande La commande
     * @param UploadedFile $file La pièce jointe
     * @return void
     */
    public function updateFile(Commande $commande, UploadedFile $file)
    {
        $path = $file->storeAs('devis', $commande->numero . '.' . $file->clientExtension(), "public");

        if ($path)
        {
            $commande->file_path = $path;
            $commande->update();
        }
        return true;
    }
}
