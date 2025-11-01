<?php

namespace App\Http\Controllers;

use App\Models\Alojamiento;
use App\Models\Tipos_alojamiento;
use Illuminate\Http\Request;

class TiposAlojamientoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $viewtypelodging = Tipos_alojamiento::all();
        $idtypelodging = Tipos_alojamiento::all();
        $viewalojamiento = Alojamiento::all();
        return view('lodging.lodging', compact('viewtypelodging', 'idtypelodging', 'viewalojamiento'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $createlodging = new Tipos_alojamiento;
        $createlodging->nombre_alojamiento = $request->nombre_alojamiento;

        //dd($createlodging);
        $createlodging->save();

        return back()->with('mensaje', 'Tipo Alojamiento Creado!!');

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $edittypelodging = Tipos_alojamiento::findOrFail($id);
        $edittypelodging->nombre_alojamiento = $request->nombre_alojamiento;

        $edittypelodging->save();

        return back()->with('mensaje', 'Tipo Alojamiento Editado!!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $deletetypelodging = Tipos_alojamiento::findOrFail($id);

        $deletetypelodging->delete();

        return back()->with('mensaje', 'Tipo Alojamiento Eliminado!!');
    }
}
