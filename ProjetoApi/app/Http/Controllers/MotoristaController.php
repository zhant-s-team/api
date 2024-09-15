<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MotoristaController extends Controller
{
    public function index()
    {
        return Motorista::all();
    }

    public function store(Request $request)
    {
        $motorista = Motorista::create($request->all());
        return response()->json($motorista, 201);
    }

    public function show(string $id)
    {
        return Motorista::findOrFail($id);
    }

    public function update(Request $request, string $id)
    {
        $motorista = Motorista::findOrFail($id);
        $motorista->update($request->all());
        return response()->json($motorista, 200);
    }

    public function destroy(string $id)
    {
        Motorista::destroy($id);
        return response()->json(null, 204);
    }
}
