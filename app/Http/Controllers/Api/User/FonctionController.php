<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Personnel\NewFonctionRequest;
use App\Models\Personnel\Fonction;
use Illuminate\Http\Request;

class FonctionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Fonction::paginate();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(NewFonctionRequest $request)
    {
        $data = $request->validated();

        $permissions = $data["permissions"];

        unset($data["permissions"]);

        $fonction = Fonction::create($data);

        return $fonction;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Personnel\Fonction  $fonction
     * @return \Illuminate\Http\Response
     */
    public function show(Fonction $fonction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Personnel\Fonction  $fonction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Fonction $fonction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Personnel\Fonction  $fonction
     * @return \Illuminate\Http\Response
     */
    public function destroy(Fonction $fonction)
    {
        //
    }
}
