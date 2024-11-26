<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Models\typebien;
use Illuminate\Http\Request;

class TypebienController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $typebiens = typebien::latest()->paginate(25);

        return $typebiens;
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
        
        $typebien = typebien::create($request->all());

        return response()->json($typebien, 201);
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
        $typebien = typebien::findOrFail($id);

        return $typebien;
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
        
        $typebien = typebien::findOrFail($id);
        $typebien->update($request->all());

        return response()->json($typebien, 200);
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
        typebien::destroy($id);

        return response()->json(null, 204);
    }
}
