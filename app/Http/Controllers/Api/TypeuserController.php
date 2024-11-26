<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Models\typeuser;
use Illuminate\Http\Request;

class TypeuserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $typeusers = typeuser::latest()->paginate(25);

        return $typeusers;
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
        
        $typeuser = typeuser::create($request->all());

        return response()->json($typeuser, 201);
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
        $typeuser = typeuser::findOrFail($id);

        return $typeuser;
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
        
        $typeuser = typeuser::findOrFail($id);
        $typeuser->update($request->all());

        return response()->json($typeuser, 200);
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
        typeuser::destroy($id);

        return response()->json(null, 204);
    }
}
