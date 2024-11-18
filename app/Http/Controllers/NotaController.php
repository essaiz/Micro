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
        
        if ($notas->isEmpty()) {
            return response()->json(['message' => 'No hay notas registradas para este estudiante.'], 404);
        }

        return response()->json($notas);
    }

    // Registrar 
    public function store(Request $request, $estudiante_id)
    {
        $request->validate([
            'actividad' => 'required',
            'nota' => 'required|numeric|min:0|max:5',
        ]);
        $estudiante = Estudiante::find($estudiante_id);
        if (!$estudiante) {
            return response()->json(['message' => 'Estudiante no encontrado'], 404);
        }

        $nota = Nota::create([
            'actividad' => $request->actividad,
            'nota' => $request->nota,
            'codEstudiante' => $estudiante_id,
        ]);

        return response()->json(['message' => 'Nota registrada con éxito', 'data' => $nota], 201);
    }

    // Actualizar
    public function update(Request $request, $id)
    {
        $nota = Nota::find($id);
        if (!$nota) {
            return response()->json(['message' => 'Nota no encontrada'], 404);
        }

        $request->validate([
            'actividad' => 'required',
            'nota' => 'required|numeric|min:0|max:5',
        ]);

        $nota->update([
            'actividad' => $request->actividad,
            'nota' => $request->nota,
        ]);

        return response()->json(['message' => 'Nota actualizada con éxito', 'data' => $nota]);
    }

    // Eliminar
    public function destroy($id)
    {
        $nota = Nota::find($id);
        if (!$nota) {
            return response()->json(['message' => 'Nota no encontrada'], 404);
        }

        $nota->delete();

        return response()->json(['message' => 'Nota eliminada con éxito']);
    }
}