<?php

namespace App\Http\Controllers;

use App\Models\Alojamiento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AlojamientoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $viewlodging = Alojamiento::withAvg('reseñas', 'puntuacion')->get();
        return view('home.home', compact('viewlodging'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'imagen' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $createalojamiento = new Alojamiento;
        $createalojamiento->nombre = $request->nombre;
        $createalojamiento->ubicacion = $request->ubicacion;
        $createalojamiento->precio = $request->precio;
        $createalojamiento->descripcion = $request->descripcion;
        $createalojamiento->cpacidad = $request->cpacidad;
        $createalojamiento->id_tipo_alojamiento = $request->id_tipo_alojamiento;

        if($request->hasFile('imagen')){
            $path = $request->file('imagen')->store('images', 'public');
            $createalojamiento->imagen = $path;
        }

        //dd($createalojamiento);
        $createalojamiento->save();

        return back()->with('mensaje', 'Alojamiento Agregado!!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
        'imagen' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'nombre' => 'required|string|max:255',
        'ubicacion' => 'required|string|max:255',
        'precio' => 'required|numeric|min:0',
        'descripcion' => 'required|string',
        'cpacidad' => 'required|integer|min:1',
        'id_tipo_alojamiento' => 'required|exists:tipos_alojamientos,id',
        'disponible' => 'boolean',
    ]);

        $updatealojamiento = Alojamiento::findOrFail($id);
        $updatealojamiento->nombre = $request->nombre;
        $updatealojamiento->ubicacion = $request->ubicacion;
        $updatealojamiento->precio = $request->precio;
        $updatealojamiento->descripcion = $request->descripcion;
        $updatealojamiento->cpacidad = $request->cpacidad;
        $updatealojamiento->id_tipo_alojamiento = $request->id_tipo_alojamiento;

        if($request->hasFile('imagen')){
            if($updatealojamiento->imagen){
                Storage::disk('public')->delete($updatealojamiento->imagen);
            }

            $path = $request->file('imagen')->store('images', 'public');
            $updatealojamiento->imagen = $path;
        }

        //dd($updatealojamiento);
        $updatealojamiento->save();

        return back()->with('mensaje', 'Alojamiento Editado!!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Alojamiento $alojamiento)
    {
        // Verificar si tiene reservas activas
        if ($alojamiento->reservas()->where('estado', true)->exists()) {
            return back()->withErrors('No se puede eliminar un alojamiento con reservas activas.');
        }

        $alojamiento->delete();
        return back()->with('mensaje', 'Alojamiento eliminado.');
    }
}

/*$deletealojamiento = Alojamiento::findOrFail($id);

        $deletealojamiento->delete();

        return back()->with('mensaje', 'Alojamiento Eliminado!!');*/
