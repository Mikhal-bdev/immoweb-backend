<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Quartier;
use Illuminate\Http\Request;

class QuartierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 25); // Par défaut, 25 éléments par page
        $search = $request->get('search'); // Recherche par nom
        $sortBy = $request->get('sort_by', 'created_at'); // Champ de tri (par défaut : date de création)
        $sortOrder = $request->get('sort_order', 'desc'); // Ordre de tri (par défaut : décroissant)

        $query = Quartier::query();

        // Recherche par nom
        if ($search) {
            $query->where('nom_qtier', 'LIKE', "%$search%");
        }

        // Tri des résultats
        $query->orderBy($sortBy, $sortOrder);

        $quartiers = $query->paginate($perPage);

        return response()->json($quartiers, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validation des données
        $validated = $request->validate([
            'nom_qtier' => 'required|string|max:255',
            'arrondissement_id' => 'required|exists:arrondissements,id',
        ]);

        $quartier = Quartier::create($validated);

        return response()->json($quartier, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $quartier = Quartier::find($id);

        if (!$quartier) {
            return response()->json(['message' => 'Quartier non trouvé.'], 404);
        }

        return response()->json($quartier, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $quartier = Quartier::find($id);

        if (!$quartier) {
            return response()->json(['message' => 'Quartier non trouvé.'], 404);
        }

        // Validation des données
        $validated = $request->validate([
            'nom_qtier' => 'sometimes|required|string|max:255',
            'arrondissement_id' => 'sometimes|required|exists:arrondissements,id',
        ]);

        $quartier->update($validated);

        return response()->json($quartier, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $quartier = Quartier::find($id);

        if (!$quartier) {
            return response()->json(['message' => 'Quartier non trouvé.'], 404);
        }

        $quartier->delete();

        return response()->json(['message' => 'Quartier supprimé avec succès.'], 204);
    }
}
