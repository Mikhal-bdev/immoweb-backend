<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Commune;
use App\Models\Departement;
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
        // Recherche et tri pour les pays
        $search = $request->get('search');
        $sort = $request->get('sort', 'code'); // Tri par défaut par code
        $direction = $request->get('direction', 'asc'); // Ordre par défaut ascendant
    
        $payss = Payss::when($search, function ($query, $search) {
            return $query->where('code', 'like', "%{$search}%")
                ->orWhere('alpha2', 'like', "%{$search}%")
                ->orWhere('alpha3', 'like', "%{$search}%")
                ->orWhere('nom_en_gb', 'like', "%{$search}%")
                ->orWhere('nom_fr_fr', 'like', "%{$search}%");
        })
        ->orderBy($sort, $direction)
        ->paginate(10);
    
        // Recherche pour les départements
        $departements = Departement::when($search, function ($query, $search) {
            return $query->where('nom_dep', 'like', "%{$search}%");
        })
        ->orderBy('nom_dep', 'asc')
        ->paginate(10);
    
        // Recherche pour les communes
        $communes = Commune::when($search, function ($query, $search) {
            return $query->where('nom_commune', 'like', "%{$search}%");
        })
        ->orderBy('nom_commune', 'asc')
        ->paginate(10);
    
        // Retour à la vue avec les données
        return view('pays.index', compact('payss', 'departements', 'communes'));
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
