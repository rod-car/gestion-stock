<?php

namespace App\Http\Controllers\Api\Parametres;

use App\Http\Controllers\Controller;
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
        $parametre = Parametre::first();
        return $parametre;
    }


    /**
     * Enregistrer l'information de l'entreprise
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $parametre = Parametre::create([
            "generale" => $data,
        ]);
        return $parametre;
    }


    /**
     * Undocumented function
     *
     * @param Parametre $parametre
     * @param Request $request
     * @return Response
     */
    public function update(Parametre $parametre, Request $request)
    {
        $data = $request->all();
        $parametre->generale = $data;
        $parametre->save();

        return response()->json([
            "success" => "Mis a jour avec succes",
        ]);
    }
}
