<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Departement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DepartementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $departements = Departement::latest()->paginate(25);
        return response()->json($departements, 200);
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
            'nom_dep' => 'required|string|max:255',
            'payss_id' => 'required|exists:pays,id', // Validation de la clé étrangère
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ], 422);
        }

        $departement = Departement::create($request->all());

        return response()->json([
            'message' => 'Departement created successfully',
            'data' => $departement,
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $departement = Departement::find($id);

        if (!$departement) {
            return response()->json([
                'message' => 'Departement not found',
            ], 404);
        }

        return response()->json($departement, 200);
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
        $departement = Departement::find($id);

        if (!$departement) {
            return response()->json([
                'message' => 'Departement not found',
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'nom_dep' => 'sometimes|required|string|max:255',
            'payss_id' => 'sometimes|required|exists:pays,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ], 422);
        }

        $departement->update($request->all());

        return response()->json([
            'message' => 'Departement updated successfully',
            'data' => $departement,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $departement = Departement::find($id);

        if (!$departement) {
            return response()->json([
                'message' => 'Departement not found',
            ], 404);
        }

        $departement->delete();

        return response()->json([
            'message' => 'Departement deleted successfully',
        ], 204);
    }
}