<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\LogActivity;
use App\Models\payss;
use Illuminate\Http\Request;

class PayssController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Récupérer l'utilisateur connecté
        $user = auth()->user();

        // Vérifier si l'utilisateur appartient au service "Caisse" ou s'il a le rôle "Admin" ou "SU Admin"
        if (!in_array($user->role, ['Admin', 'SU Admin'])) {
            return abort(403, 'Accès non autorisé');
        }

        $search = $request->get('search');
        $sort = $request->get('sort', 'code'); // Tri par défaut par 'code'
        $direction = $request->get('direction', 'asc'); // Ordre par défaut ascendant

        $payss = Payss::when($search, function ($query, $search) {
            return $query->where('code', 'like', "%{$search}%")
                ->orWhere('alpha2', 'like', "%{$search}%")
                ->orWhere('alpha3', 'like', "%{$search}%")
                ->orWhere('nom_en_gb', 'like', "%{$search}%")
                ->orWhere('nom_fr_fr', 'like', "%{$search}%");
        })
            ->orderBy($sort, $direction) // Tri par le champ spécifié
            ->paginate(10); // Pagination à 10 éléments par page

        // Enregistrer un log pour la consultation des factures
        LogActivity::addToLog('Consultation', 'Consultation de la liste des pays.');

        $payss = payss::latest()->paginate(25);

        return $payss;
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
        
        $payss = payss::create($request->all());

        return response()->json($payss, 201);
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
        $payss = payss::findOrFail($id);

        return $payss;
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
        
        $payss = payss::findOrFail($id);
        $payss->update($request->all());

        return response()->json($payss, 200);
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
        payss::destroy($id);

        return response()->json(null, 204);
    }
}
