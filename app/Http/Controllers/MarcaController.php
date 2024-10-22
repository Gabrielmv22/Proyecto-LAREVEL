<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMarcaRequest;
use App\Http\Requests\UpdateMarcaRequest;
use App\Models\Marca;
use App\Models\Caracteristica; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class MarcaController extends Controller
{
    public function index()
    {
        $marcas = Marca::with('caracteristica')->latest()->get();
        return view('marca.index', ['marcas' => $marcas]);
    }

    public function create()
    {
        return view('marca.create');
    }

    public function store(StoreMarcaRequest $request)
    {
        try {
            DB::beginTransaction();
            
            // Creamos la característica
            $caracteristica = Caracteristica::create($request->validated());

            // Creamos la marca relacionada con la característica
            $marca = new Marca();
            $marca->caracteristica_id = $caracteristica->id;
            $marca->save();

            DB::commit();
            return redirect()->route('marcas.index')->with('success', 'Marca registrada correctamente.');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->route('marcas.index')->with('error', 'Error al registrar la marca.');
        }
    }

    public function edit(Marca $marca)
    {
        return view('marca.edit', ['marca' => $marca]);
    }

    public function update(UpdateMarcaRequest $request, Marca $marca)
    {
        try {
            // Actualizamos los datos de la característica relacionada
            $marca->caracteristica->update($request->validated());
            return redirect()->route('marcas.index')->with('success', 'Marca editada correctamente.');
        } catch (Exception $e) {
            return redirect()->route('marcas.index')->with('error', 'Error al editar la marca.');
        }
    }

    public function destroy(Marca $marca)
    {
        try {
            $estado = $marca->caracteristica->estado == 1 ? 0 : 1;
            $marca->caracteristica->update(['estado' => $estado]);
            $message = $estado == 0 ? 'Marca eliminada' : 'Marca restaurada';
            return redirect()->route('marcas.index')->with('success', $message);
        } catch (Exception $e) {
            return redirect()->route('marcas.index')->with('error', 'Error al cambiar el estado de la marca.');
        }
    }
}
