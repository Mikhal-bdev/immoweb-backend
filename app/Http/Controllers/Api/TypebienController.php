<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Typebien;
use Illuminate\Http\Request;

class TypebienController extends Controller
{
    /**
     * Display a listing of the resource with search and sorting.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Récupérer les paramètres de recherche et tri
        $search = $request->input('search'); // Terme de recherche
        $sortBy = $request->input('sortBy', 'created_at'); // Champ de tri (par défaut : created_at)
        $sortOrder = $request->input('sortOrder', 'desc'); // Ordre de tri (par défaut : desc)

        // Construire la requête
        $query = Typebien::query();

        // Appliquer le filtre de recherche
        if ($search) {
            $query->where('type', 'LIKE', "%{$search}%")
                ->orWhere('designation', 'LIKE', "%{$search}%");
        }

        // Appliquer le tri
        $query->orderBy($sortBy, $sortOrder);

        // Pagination des résultats
        $typebiens = $query->paginate(25);

        return response()->json($typebiens);
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
        $typebien = Typebien::create($request->all());

        return response()->json($typebien, 201);
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
        $typebien = Typebien::findOrFail($id);

        return response()->json($typebien);
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
        $typebien = Typebien::findOrFail($id);
        $typebien->update($request->all());

        return response()->json($typebien, 200);
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
        Typebien::destroy($id);

        return response()->json(null, 204);
    }
}
