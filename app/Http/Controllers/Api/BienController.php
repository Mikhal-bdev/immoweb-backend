<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Bien;
use Illuminate\Http\Request;

class BienController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Recherche, tri et pagination
        $query = Bien::query();

        // Filtres de recherche
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('designation', 'like', "%$search%")
                  ->orWhere('desc', 'like', "%$search%")
                  ->orWhere('localisation', 'like', "%$search%");
        }

        // Tri
        if ($request->has('sortBy') && $request->has('sortOrder')) {
            $query->orderBy($request->input('sortBy'), $request->input('sortOrder'));
        } else {
            $query->latest(); // Tri par défaut
        }

        // Pagination
        $biens = $query->paginate($request->input('perPage', 25));

        return response()->json($biens);
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
        $validated = $request->validate([
            'typebien_id' => 'required|exists:typebiens,id',
            'user_id' => 'required|exists:users,id',
            'designation' => 'required|string|max:255',
            'nbrchambr' => 'required|integer|min:0',
            'long' => 'required|numeric',
            'larg' => 'required|numeric',
            'etat' => 'required|string|max:255',
            'localisation' => 'required|string|max:255',
            'map' => 'nullable|string',
            'desc' => 'nullable|string',
            'conditions' => 'nullable|string',
            'loyer' => 'required|numeric',
            'avance' => 'required|numeric',
            'caution' => 'required|numeric',
            'compteau' => 'nullable|string|max:255',
            'comptelec' => 'nullable|string|max:255',
            'locatorsell' => 'required|string|max:255',
            'photo1' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'photo2' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'photo3' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'photo4' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'photo5' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'photo6' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Gestion des fichiers d'images
        foreach (['photo1', 'photo2', 'photo3', 'photo4', 'photo5', 'photo6'] as $photoField) {
            if ($request->hasFile($photoField)) {
                $validated[$photoField] = $request->file($photoField)->store('biens/photos', 'public');
            }
        }

        $bien = Bien::create($validated);

        return response()->json($bien, 201);
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
        $bien = Bien::findOrFail($id);

        return response()->json($bien);
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
        $bien = Bien::findOrFail($id);

        $validated = $request->validate([
            'typebien_id' => 'exists:typebiens,id',
            'user_id' => 'exists:users,id',
            'designation' => 'string|max:255',
            'nbrchambr' => 'integer|min:0',
            'long' => 'numeric',
            'larg' => 'numeric',
            'etat' => 'string|max:255',
            'localisation' => 'string|max:255',
            'map' => 'nullable|string',
            'desc' => 'nullable|string',
            'conditions' => 'nullable|string',
            'loyer' => 'numeric',
            'avance' => 'numeric',
            'caution' => 'numeric',
            'compteau' => 'nullable|string|max:255',
            'comptelec' => 'nullable|string|max:255',
            'locatorsell' => 'string|max:255',
            'photo1' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'photo2' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'photo3' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'photo4' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'photo5' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'photo6' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        foreach (['photo1', 'photo2', 'photo3', 'photo4', 'photo5', 'photo6'] as $photoField) {
            if ($request->hasFile($photoField)) {
                $validated[$photoField] = $request->file($photoField)->store('biens/photos', 'public');
            }
        }

        $bien->update($validated);

        return response()->json($bien, 200);
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
        Bien::destroy($id);

        return response()->json(null, 204);
    }
}
