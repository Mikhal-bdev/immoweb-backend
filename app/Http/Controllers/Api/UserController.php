<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Recherche par nom, prénom ou email
        $query = User::query();

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('nom', 'like', "%$search%")
                ->orWhere('prenom', 'like', "%$search%")
                ->orWhere('email', 'like', "%$search%");
        }

        // Tri par champ spécifique
        if ($request->has('sort_by') && $request->has('order')) {
            $sortBy = $request->input('sort_by');
            $order = $request->input('order') === 'desc' ? 'desc' : 'asc';
            $query->orderBy($sortBy, $order);
        } else {
            $query->latest(); // Par défaut, tri par date de création décroissante
        }

        // Pagination
        $users = $query->paginate($request->input('per_page', 25));

        return response()->json($users, 200);
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
        // Validation des données
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'adresse' => 'required|string|max:255',
            'numtel' => 'nullable|string|min:8|max:15|regex:/^(\+?[0-9]{1,4}\s?)?[0-9]{8,11}$/', // Format de téléphone
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'pays_id' => 'nullable|exists:payss,id',
            'departement_id' => 'nullable|exists:departements,id',
            'commune_id' => 'nullable|exists:communes,id',
            'ville_id' => 'nullable|exists:villes,id',
            'arrondissement_id' => 'nullable|exists:arrondissements,id',
            'quartier_id' => 'nullable|exists:quartiers,id',
            'typeuser_id' => 'required|exists:typeusers,id',
            'profile_photo_path' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Validation de la photo de profil
        ]);

        // Gestion de l'upload de la photo de profil
        $profilePhotoPath = null;
        if ($request->hasFile('profile_photo_path')) {
            $profilePhotoPath = $request->file('profile_photo_path')->store('profile_photos', 'public');
        }

        // Création de l'utilisateur avec les données
        $user = User::create([
            'nom' => $request->input('nom'),
            'prenom' => $request->input('prenom'),
            'email' => $request->input('email'),
            'adresse' => $request->input('adresse'),
            'numtel' => $request->input('numtel'),
            'password' => bcrypt($request->input('password')), // Hash du mot de passe
            'pays_id' => $request->input('pays_id'),
            'departement_id' => $request->input('departement_id'),
            'commune_id' => $request->input('commune_id'),
            'ville_id' => $request->input('ville_id'),
            'arrondissement_id' => $request->input('arrondissement_id'),
            'quartier_id' => $request->input('quartier_id'),
            'typeuser_id' => $request->input('typeuser_id'),
            'profile_photo_path' => $profilePhotoPath,
        ]);

        return response()->json($user, 201);
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
        $user = User::findOrFail($id);

        return response()->json($user, 200);
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
        // Validation des données
        $request->validate([
            'nom' => 'nullable|string|max:255',
            'prenom' => 'nullable|string|max:255',
            'email' => 'nullable|email|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8',
            'pays_id' => 'nullable|exists:payss,id',
            'departement_id' => 'nullable|exists:departements,id',
            'commune_id' => 'nullable|exists:communes,id',
            'ville_id' => 'nullable|exists:villes,id',
            'arrondissement_id' => 'nullable|exists:arrondissements,id',
            'quartier_id' => 'nullable|exists:quartiers,id',
            'typeuser_id' => 'nullable|exists:typeusers,id',
        ]);

        // Mise à jour de l'utilisateur
        $user = User::findOrFail($id);
        $user->update($request->all());

        return response()->json($user, 200);
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
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json(null, 204);
    }
}
