<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\ModifierClientRequest;
use App\Http\Requests\Client\NouveauClientRequest;
use App\Models\Client\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Client::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Client\NouveauClientRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(NouveauClientRequest $request)
    {
        $data = $request->validated();
        $categories = $data["categories"];
        unset($data["categories"]);

        $client = Client::create($data);

        foreach ($categories as $id) {
            $client->categories()->attach($id);
        }

        return $client;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Client\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function show(Client $client)
    {
        return $client;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Http\Requests\Client\ModifierClientRequest  $client
     * @return \Illuminate\Http\Response
     */
    public function update(ModifierClientRequest $request, Client $client)
    {
        $data = $request->validated();
        $categories = $data["categories"];

        unset($data["categories"]);

        $client->update($data);

        $categoriesActuel = $client->categories->pluck('id');

        foreach ($categoriesActuel as $id) {
            if (!in_array($id, $categories)) $client->categories()->detach($id);
        }

        foreach ($categories as $id) {
            if (!$client->categories->contains($id)) $client->categories()->attach($id);
        }

        return response()->json(["success" => "Modifié avec succès"]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Client\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $client)
    {
        $client->categories()->detach();
        $client->delete();
        return response()->json(["success" => "Supprimé avec succès"]);
    }
}
