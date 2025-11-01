<?php

namespace App\Http\Controllers;

use App\Models\Alojamiento;
use App\Models\Reserva;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservaController extends Controller
{
    public function misReservas(){
        $viewreservas = Reserva::with('alojamiento')
            ->where('id_usuario', Auth::id())
            ->where('estado', true)
            ->latest()
            ->get();

            return view('reservation.reservations', compact('viewreservas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'id_alojamiento' => 'required|exists:alojamientos,id',
            'fecha_inicio' => 'required|date|after_or_equal:today',
            'fecha_fin' => 'required|date|after:fecha_inicio',
        ]);

        $alojamiento = Alojamiento::findOrFail($request->id_alojamiento);
        $fechaInicio = Carbon::parse($request->fecha_inicio);
        $fechaFin = Carbon::parse($request->fecha_fin);

        // Verificar si hay conflictos con reservas existentes
        $conflicto = Reserva::where('id_alojamiento', $alojamiento->id)
        ->where('estado', true) //reservas activas
        ->where(function ($query) use ($fechaInicio, $fechaFin) {
            $query->whereBetween('fecha_inicio', [$fechaInicio, $fechaFin])
                ->orWhereBetween('fecha_fin', [$fechaInicio, $fechaFin])
                ->orWhere(function ($q) use ($fechaInicio, $fechaFin){
                    $q->where('fecha_inicio', '<=', $fechaInicio)
                    ->where('fecha_fin', '>=', $fechaFin);
                });
        })->exists();

        if ($conflicto) {
            return back()->withErrors(['fecha_inicio' => 'Las fechas seleccionadas ya están reservadas. Por favor, elige otras fechas.']);
        }

        $dias = $fechaInicio->diffInDays($fechaFin);
        $precioTotal = $dias * $alojamiento->precio;


        Reserva::create([
            'id_usuario' => Auth::id(),
            'id_alojamiento' => $alojamiento->id,
            'fecha_inicio' => $fechaInicio,
            'fecha_fin' => $fechaFin,
            'estado' => true,
            'precio_total' => $precioTotal,
        ]);

        //dd($request);

        return redirect()->route('home')->with('mensaje', 'Reserva realizada con éxito!!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $alojamientos = Alojamiento::findOrFail($id);
        return view('home.detail.detail', compact('alojamientos'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Reserva $reserva)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Reserva $reserva)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reserva $reserva)
    {
        if($reserva->id_usuario !== Auth::id()){
            abort(403, 'No autorizado');
        }

        if ($reserva->estado === false) {
            return redirect()->route('reserva.index')->with('mensaje', 'Esta reserva ya fue cancelada.');
        }

        $reserva->update(['estado' => false]);

        return redirect()->route('reserva.index')->with('mensaje', 'Reserva cancela correctamente.');
    }
}


        /*if(!$alojamiento->disponible){
            return back()->withErrors('Este alojamiento ya no esta disponible');
        }*/
