<?php

namespace App\Http\Controllers;

use App\Models\Agence;
use App\Models\Bien;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Affiche les agences certifiées et les biens par type.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        // 1. Récupérer les agences certifiées
        $agences_certifiees = Agence::where('certifiee', true)->get();

        // 2. Récupérer 3 biens pour chaque type
        $types = ['Appartement', 'Boutique', 'Maison', 'Terrain']; // Ajouter vos types ici
        $biens_par_type = [];

        foreach ($types as $type) {
            $biens_par_type[$type] = Bien::where('type', $type)
                ->take(3)
                ->get();
        }

        return response()->json([
            'agences_certifiees' => $agences_certifiees,
            'biens_par_type' => $biens_par_type,
        ], 200);
    }

    /**
     * Effectue une recherche avancée.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(Request $request)
    {
        // 1. Récupérer les critères de recherche
        $type = $request->input('type'); // Type de bien
        $min_longueur = $request->input('min_longueur'); // Longueur minimale
        $max_longueur = $request->input('max_longueur'); // Longueur maximale
        $min_largeur = $request->input('min_largeur'); // Largeur minimale
        $max_largeur = $request->input('max_largeur'); // Largeur maximale
        $min_loyer = $request->input('min_loyer'); // Loyer minimal
        $max_loyer = $request->input('max_loyer'); // Loyer maximal
        $agence_certifiee = $request->input('certifiee', false); // Biens publiés par agences certifiées

        // 2. Construire la requête
        $query = Bien::query();

        if ($type) {
            $query->where('type', $type);
        }

        if ($min_longueur && $max_longueur) {
            $query->whereBetween('longueur', [$min_longueur, $max_longueur]);
        }

        if ($min_largeur && $max_largeur) {
            $query->whereBetween('largeur', [$min_largeur, $max_largeur]);
        }

        if ($min_loyer && $max_loyer) {
            $query->whereBetween('loyer', [$min_loyer, $max_loyer]);
        }

        if ($agence_certifiee) {
            $query->whereHas('agence', function ($q) {
                $q->where('certifiee', true);
            });
        }

        // 3. Exécuter la requête
        $resultats = $query->paginate(10); // Pagination

        return response()->json($resultats, 200);
    }
}
