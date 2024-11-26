<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Privilege;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PrivilegeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $privileges = Privilege::latest()->paginate(25);

        return response()->json($privileges, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'idtypeuser' => 'required|integer',
            'typepriv' => 'required|string|max:255',
            'designpriv' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $privilege = Privilege::create($request->all());

        return response()->json($privilege, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $privilege = Privilege::find($id);

        if (!$privilege) {
            return response()->json(['message' => 'Privilege not found'], 404);
        }

        return response()->json($privilege, 200);
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
        $validator = Validator::make($request->all(), [
            'idtypeuser' => 'sometimes|required|integer',
            'typepriv' => 'sometimes|required|string|max:255',
            'designpriv' => 'sometimes|required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $privilege = Privilege::find($id);

        if (!$privilege) {
            return response()->json(['message' => 'Privilege not found'], 404);
        }

        $privilege->update($request->all());

        return response()->json($privilege, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $privilege = Privilege::find($id);

        if (!$privilege) {
            return response()->json(['message' => 'Privilege not found'], 404);
        }

        $privilege->delete();

        return response()->json(null, 204);
    }
}