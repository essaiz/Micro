<?php

namespace App\Http\Controllers;

use App\Models\Estudiante;
use Illuminate\Http\Request;

class EstudianteController extends Controller
{
    public function index()
    {
        return response()->json(Estudiante::with('notas')->get());
    }

    public function store(Request $request)
    {
        $request->validate([
            'cod' => 'required|unique:estudiantes',
            'nombres' => 'required',
            'email' => 'required|email|unique:estudiantes',
        ]);

        $estudiante = Estudiante::create($request->all());
        return response()->json(['message' => 'Estudiante creado con éxito', 'data' => $estudiante]);
    }

    public function update(Request $request, $id)
    {
        $estudiante = Estudiante::findOrFail($id);

        $request->validate([
            'cod' => 'required|unique:estudiantes,cod,' . $estudiante->id,
            'email' => 'required|email|unique:estudiantes,email,' . $estudiante->id,
        ]);

        $estudiante->update($request->all());
        return response()->json(['message' => 'Estudiante actualizado con éxito', 'data' => $estudiante]);
    }

    public function destroy($id)
    {
        $estudiante = Estudiante::findOrFail($id);

        if ($estudiante->notas()->count() > 0) {
            return response()->json(['error' => 'No se puede eliminar un estudiante con notas'], 400);
        }

        $estudiante->delete();
        return response()->json(['message' => 'Estudiante eliminado con éxito']);
    }
}
