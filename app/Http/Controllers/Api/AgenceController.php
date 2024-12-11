<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Agence;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AgenceController extends Controller
{
    /**
     * Affiche une liste des agences.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->input('search'); // Recherche
        $sort = $request->input('sort', 'created_at'); // Tri par défaut : 'created_at'
        $direction = $request->input('direction', 'desc'); // Direction par défaut : 'desc'
        $perPage = $request->input('per_page', 25); // Nombre d'éléments par page par défaut : 25

        $agences = Agence::query()
            ->when($search, function ($query, $search) {
                $query->where('nom', 'like', '%' . $search . '%')
                    ->orWhere('adresse', 'like', '%' . $search . '%');
            })
            ->orderBy($sort, $direction) // Appliquer le tri dynamique
            ->paginate($perPage); // Appliquer la pagination

        return response()->json($agences);
    }

    /**
     * Crée une nouvelle agence.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'nom' => 'required|string|max:255',
            'photagen' => 'nullable|image|max:2048',
            'regcomm' => 'required|string|max:255',
            'docrccm' => 'nullable|file|max:2048',
            'ifu' => 'required|string|max:255',
            'docifu' => 'nullable|file|max:2048',
            'numcni' => 'required|string|max:50',
            'doccni' => 'nullable|file|max:2048',
            'cip' => 'required|string|max:255',
            'doccip' => 'nullable|file|max:2048',
            'adresse' => 'required|string|max:255',
            'mail' => 'required|email|max:255',
            'contact' => 'required|string|max:50',
            'whatsapp' => 'nullable|string|max:50',
            'descrip' => 'nullable|string',
            'certification' => 'required|in:Approuvé,Non',
        ]);

        // Gestion des fichiers
        if ($request->hasFile('photagen')) {
            $validated['photagen'] = $request->file('photagen')->store('agences/photos', 'public');
        }
        foreach (['docrccm', 'docifu', 'doccni', 'doccip'] as $fileField) {
            if ($request->hasFile($fileField)) {
                $validated[$fileField] = $request->file($fileField)->store("agences/docs", 'public');
            }
        }

        $agence = Agence::create($validated);

        return response()->json([
            'message' => 'Agence créée avec succès.',
            'agence' => $agence,
        ], 201);
    }

    /**
     * Affiche une agence spécifique.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $agence = Agence::findOrFail($id);
        return response()->json($agence);
    }

    /**
     * Met à jour une agence existante.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $agence = Agence::findOrFail($id);

        $validated = $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'nom' => 'nullable|string|max:255',
            'photagen' => 'nullable|image|max:2048',
            'regcomm' => 'nullable|string|max:255',
            'docrccm' => 'nullable|file|max:2048',
            'ifu' => 'nullable|string|max:255',
            'docifu' => 'nullable|file|max:2048',
            'numcni' => 'nullable|string|max:50',
            'doccni' => 'nullable|file|max:2048',
            'cip' => 'nullable|string|max:255',
            'doccip' => 'nullable|file|max:2048',
            'adresse' => 'nullable|string|max:255',
            'mail' => 'nullable|email|max:255',
            'contact' => 'nullable|string|max:50',
            'whatsapp' => 'nullable|string|max:50',
            'descrip' => 'nullable|string',
            'certification' => 'nullable|in:Approuvé,Non',
        ]);

        // Gestion des fichiers (mise à jour et suppression des anciens)
        if ($request->hasFile('photagen')) {
            if ($agence->photagen) {
                Storage::disk('public')->delete($agence->photagen);
            }
            $validated['photagen'] = $request->file('photagen')->store('agences/photos', 'public');
        }
        foreach (['docrccm', 'docifu', 'doccni', 'doccip'] as $fileField) {
            if ($request->hasFile($fileField)) {
                if ($agence->{$fileField}) {
                    Storage::disk('public')->delete($agence->{$fileField});
                }
                $validated[$fileField] = $request->file($fileField)->store("agences/docs", 'public');
            }
        }

        $agence->update($validated);

        return response()->json([
            'message' => 'Agence mise à jour avec succès.',
            'agence' => $agence,
        ]);
    }

    /**
     * Supprime une agence.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $agence = Agence::findOrFail($id);

        // Supprimer les fichiers liés
        foreach (['photagen', 'docrccm', 'docifu', 'doccni', 'doccip'] as $fileField) {
            if ($agence->{$fileField}) {
                Storage::disk('public')->delete($agence->{$fileField});
            }
        }

        $agence->delete();

        return response()->json([
            'message' => 'Agence supprimée avec succès.',
        ], 204);
    }
}
