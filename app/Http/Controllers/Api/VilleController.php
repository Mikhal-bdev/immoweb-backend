<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Models\ville;
use Illuminate\Http\Request;

class VilleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->input('search'); // Récupère le terme de recherche
        $sortBy = $request->input('sortBy', 'created_at'); // Par défaut trié par 'created_at'
        $sortOrder = $request->input('sortOrder', 'desc'); // Ordre décroissant par défaut

        $villes = Ville::search($search)
            ->sort($sortBy, $sortOrder)
            ->paginate(25);

        return response()->json($villes);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $ville = ville::create($request->all());

        return response()->json($ville, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $ville = ville::findOrFail($id);

        return $ville;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $ville = ville::findOrFail($id);
        $ville->update($request->all());

        return response()->json($ville, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        ville::destroy($id);

        return response()->json(null, 204);
    }
}
