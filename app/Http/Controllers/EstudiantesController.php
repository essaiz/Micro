<?php

namespace App\Http\Controllers;

use App\Models\Estudiante;
use App\Models\Nota;
use Illuminate\Http\Request;

class EstudianteController extends Controller
{
    // Mostrar 
    public function index()
    {
        $estudiantes = Estudiante::all();
        return response()->json($estudiantes);
    }
    public function show($id)
    {
        $estudiante = Estudiante::findOrFail($id);
        $notas = Nota::where('codEstudiante', $id)->get();
        
        //(promedio)
        $promedio = $notas->avg('nota');
        
        //estado 
        $estado = $promedio >= 3 ? 'Aprobado' : 'Perdió';

        return response()->json([
            'estudiante' => $estudiante,
            'notas' => $notas,
            'promedio' => $promedio,
            'estado' => $estado
        ]);
    }

    // Registrar
    public function store(Request $request)
    {
        $request->validate([
            'cod' => 'required|unique:estudiantes,cod',
            'email' => 'required|email|unique:estudiantes,email',
            'nombres' => 'required|string|max:255',
        ]);

        $estudiante = Estudiante::create([
            'cod' => $request->cod,
            'email' => $request->email,
            'nombres' => $request->nombres,
        ]);

        return response()->json([
            'message' => 'Estudiante registrado con éxito',
            'data' => $estudiante
        ]);
    }

    // Actualizar
    public function update(Request $request, $id)
    {
        $estudiante = Estudiante::findOrFail($id);
        $request->validate([
            'cod' => 'required|unique:estudiantes,cod,' . $estudiante->id,
            'email' => 'required|email|unique:estudiantes,email,' . $estudiante->id,
            'nombres' => 'required|string|max:255',
        ]);

        $estudiante->update([
            'cod' => $request->cod,
            'email' => $request->email,
            'nombres' => $request->nombres,
        ]);

        return response()->json([
            'message' => 'Estudiante actualizado con éxito',
            'data' => $estudiante
        ]);
    }
    // Eliminar 
    public function destroy($id)
    {
        $estudiante = Estudiante::findOrFail($id);

        // Verificar
        $notas = Nota::where('codEstudiante', $id)->count();
        if ($notas > 0) {
            return response()->json([
                'message' => 'No se puede eliminar el estudiante porque tiene notas registradas.'
            ], 400);
        }

        $estudiante->delete();

        return response()->json([
            'message' => 'Estudiante eliminado con éxito'
        ]);
    }

    // Filtro
    public function filter(Request $request)
    {
        $query = Estudiante::query();

        if ($request->has('codigo')) {
            $query->where('cod', $request->codigo);
        }
        if ($request->has('nombre')) {
            $query->where('nombres', 'like', '%' . $request->nombre . '%');
        }
        if ($request->has('email')) {
            $query->where('email', 'like', '%' . $request->email . '%');
        }
        if ($request->has('estado')) {
            $estado = $request->estado == 'Aprobado' ? 3 : 0;
            $query->whereHas('notas', function($q) use ($estado) {
                $q->havingRaw('AVG(nota) >= ?', [$estado]);
            });
        }

        $estudiantes = $query->get();
        return response()->json($estudiantes);
    }
}