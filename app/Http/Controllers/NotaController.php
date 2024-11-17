<?php

namespace App\Http\Controllers;

use App\Models\Nota;
use App\Models\Estudiante;
use Illuminate\Http\Request;

class NotaController extends Controller
{
    public function index($estudiante_id)
    {
        $notas = Nota::where('codEstudiante', $estudiante_id)->get();
        return response()->json($notas);
    }

    public function store(Request $request, $estudiante_id)
    {
        $request->validate([
            'actividad' => 'required',
            'nota' => 'required|numeric|min:0|max:5',
        ]);

        $nota = Nota::create([
            'actividad' => $request->actividad,
            'nota' => $request->nota,
            'codEstudiante' => $estudiante_id,
        ]);

        return response()->json(['message' => 'Nota registrada con éxito', 'data' => $nota]);
    }

    public function destroy($id)
    {
        $nota = Nota::findOrFail($id);
        $nota->delete();
        return response()->json(['message' => 'Nota eliminada con éxito']);
    }
}
