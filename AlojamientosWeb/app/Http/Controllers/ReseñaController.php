<?php

namespace App\Http\Controllers;

use App\Models\Alojamiento;
use App\Models\Reseña;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReseñaController extends Controller
{
    public function index(Alojamiento $alojamiento){
        $reseñas = Reseña::with('usuario')
        ->where('id_alojamiento', $alojamiento->id)
        ->latest()
        ->get();
        return view('review.review', compact('reseñas', 'alojamiento'));
    }

    public function store(Request $request){
        $request->validate([
            'id_alojamiento' => 'required|exists:alojamientos,id',
            'puntuacion' => 'required|integer|min:1|max:5',
            'comentario' => 'required|string|max:1000',
        ]);

        $review = new Reseña;
        $review->id_usuario = Auth::id();
        $review->id_alojamiento = $request->id_alojamiento;
        $review->puntuacion = $request->puntuacion;
        $review->comentario = $request->comentario;
        $review->fecha_comentario = now();

        //dd($review);
        $review->save();

        return back()->with('mensaje', 'Reseña agregada!!');
    }

    public function update(Request $request, $id){}

    public function destroy($id){}
}
