<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Arrondissement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ArrondissementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        // Recherche et tri
        $query = Arrondissement::query();

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('nom_arrond', 'like', '%' . $search . '%');
        }

        if ($request->has('sort_by')) {
            $sortBy = $request->input('sort_by', 'created_at');
            $sortOrder = $request->input('sort_order', 'desc');
            $query->orderBy($sortBy, $sortOrder);
        }

        $arrondissements = $query->paginate(25);

        return response()->json($arrondissements);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        // Validation
        $validator = Validator::make($request->all(), [
            'nom_arrond' => 'required|string|max:255',
            'ville_id' => 'required|exists:villes,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Création
        $arrondissement = Arrondissement::create($request->only('nom_arrond', 'ville_id'));

        return response()->json($arrondissement, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $arrondissement = Arrondissement::findOrFail($id);

        return response()->json($arrondissement);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $arrondissement = Arrondissement::findOrFail($id);

        // Validation
        $validator = Validator::make($request->all(), [
            'nom_arrond' => 'sometimes|required|string|max:255',
            'ville_id' => 'sometimes|required|exists:villes,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Mise à jour
        $arrondissement->update($request->only('nom_arrond', 'ville_id'));

        return response()->json($arrondissement, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $arrondissement = Arrondissement::findOrFail($id);
        $arrondissement->delete();

        return response()->json(null, 204);
    }
}