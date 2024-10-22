<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePresentacioneRequest;
use App\Http\Requests\UpdatePresentacioneRequest;
use Illuminate\Support\Facades\DB;
use App\Models\Caracteristica;
use App\Models\Presentacione;
use Illuminate\Http\Request;

class PresentacioneController extends Controller
{
    /**
     * Muestra una lista de todas las presentaciones.
     */
    public function index()
    {
        $presentaciones = Presentacione::with('caracteristica')->latest()->get();
        return view('presentacion.index', ['presentaciones' => $presentaciones]);
    }

    /**
     * Muestra el formulario para crear una nueva presentación.
     */
    public function create()
    {
        return view('presentacion.create');
    }

    /**
     * Almacena una nueva presentación en la base de datos.
     */
    public function store(StorePresentacioneRequest $request)
    {
        try {
            DB::beginTransaction();
            $caracteristica = Caracteristica::create($request->validated());
            $caracteristica->presentacione()->create([
                'caracteristica_id' => $caracteristica->id
            ]);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
        }
        return redirect()->route('presentaciones.index')->with('success', 'Presentación registrada correctamente');
    }

    /**
     * Muestra el formulario para editar una presentación existente.
     */
    public function edit(Presentacione $presentacione)
    {
        return view('presentacion.edit', ['presentacione' => $presentacione]);
    }

    /**
     * Actualiza una presentación existente en la base de datos.
     */
    public function update(UpdatePresentacioneRequest $request, Presentacione $presentacione)
    {
        Caracteristica::where('id', $presentacione->caracteristica->id)
            ->update($request->validated());

        return redirect()->route('presentaciones.index')->with('success', 'Presentación editada correctamente');
    }

    /**
     * Cambia el estado de una presentación (eliminación lógica).
     */
    public function destroy(Presentacione $presentacione)
    {
        $message = '';
        $estado = $presentacione->caracteristica->estado;

        if ($estado == 1) {
            Caracteristica::where('id', $presentacione->caracteristica->id)->update(['estado' => 0]);
            $message = 'Presentación desactivada correctamente.';
        } else {
            Caracteristica::where('id', $presentacione->caracteristica->id)->update(['estado' => 1]);
            $message = 'Presentación activada correctamente.';
        }

        return redirect()->route('presentaciones.index')->with('success', $message);
    }
}
