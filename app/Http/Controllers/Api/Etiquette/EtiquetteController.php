<?php

namespace App\Http\Controllers\Api\Etiquette;

use App\Http\Controllers\Controller;
use App\Http\Requests\Etiquette\CreateEtiquetteRequest;
use App\Models\Etiquette;
use Illuminate\Http\Request;

class EtiquetteController extends Controller
{
    /**
     * Undocumented function
     *
     * @param Request $request
     * @return void
     */
    public function index(Request $request)
    {
        $etiquettes = Etiquette::all();

        return $etiquettes;
    }

    /**
     * Undocumented function
     *
     * @param CreateEtiquetteRequest $request
     * @return void
     */
    public function store(CreateEtiquetteRequest $request){

        $etiquette = Etiquette::create($request->all());

        return $etiquette;
    }

    public function update(){
        return
    }

    /**
     * Undocumented function
     *
     * @param Etiquette $etiquette
     * @return void
     */
    public function show(Etiquette $etiquette){
        return $etiquette;
    }
}
