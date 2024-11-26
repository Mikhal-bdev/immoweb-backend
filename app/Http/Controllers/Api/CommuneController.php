<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Commune;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CommuneController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Commune::query();

        // Recherche
        if ($request->has('search')) {
            $query->where('nom_commune', 'like', '%' . $request->search . '%');
        }

        // Tri
        if ($request->has('sortBy') && $request->has('order')) {
            $query->orderBy($request->sortBy, $request->order);
        } else {
            $query->latest(); // Tri par défaut
        }

        // Pagination
        $communes = $query->paginate($request->get('perPage', 25));

        return response()->json($communes, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nom_commune' => 'required|string|max:255',
            'departement_id' => 'required|exists:departements,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $commune = Commune::create($request->all());

        return response()->json($commune, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $commune = Commune::find($id);

        if (!$commune) {
            return response()->json(['error' => 'Commune not found'], 404);
        }

        return response()->json($commune, 200);
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
        $commune = Commune::find($id);

        if (!$commune) {
            return response()->json(['error' => 'Commune not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'nom_commune' => 'sometimes|required|string|max:255',
            'departement_id' => 'sometimes|required|exists:departements,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $commune->update($request->all());

        return response()->json($commune, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $commune = Commune::find($id);

        if (!$commune) {
            return response()->json(['error' => 'Commune not found'], 404);
        }

        $commune->delete();

        return response()->json(null, 204);
    }
}