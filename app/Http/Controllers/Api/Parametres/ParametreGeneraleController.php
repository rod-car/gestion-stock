<?php

namespace App\Http\Controllers\Api\Parametres;

use App\Http\Controllers\Controller;
use App\Http\Requests\Parametres\ParametresGeneraleRequest;
use App\Models\Parametres\Parametre;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ParametreGeneraleController extends Controller
{
    /**
     * Recuperer L'information De L'entreprise
     *
     * @return Response
     */
    public function index()
    {
        return Parametre::first();
    }


    /**
     * Enregistrer l'information de l'entreprise
     *
     * @param ParametresGeneraleRequest $request
     * @return Response
     */
    public function store(ParametresGeneraleRequest $request)
    {
        $data = $request->validated();
        $parametre = Parametre::create([
            "generale" => $data,
        ]);
        return $parametre;
    }


    /**
     * Undocumented function
     *
     * @param Parametre $parametre
     * @param ParametresGeneraleRequest $request
     * @return Response
     */
    public function update(Parametre $parametre, ParametresGeneraleRequest $request)
    {
        $data = $request->validated();
        $parametre->generale = $data;
        $parametre->save();

        return response()->json([
            "success" => "Mis a jour avec succes",
        ]);
    }
}
