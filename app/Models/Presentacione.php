<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Presentacione extends Model
{
    use HasFactory;

    // Agrega los campos que permites para la asignación masiva
    protected $fillable = [
        'caracteristica_id', // Asegúrate de incluir este campo
        'created_at', // Si lo necesitas
        'updated_at'  // Si lo necesitas
    ];

    // Relación con Producto
    public function productos()
    {
        return $this->belongsToMany(Producto::class);
    }

    // Relación con Caracteristica
    public function caracteristica()
    {
        return $this->belongsTo(Caracteristica::class); // Cambia a belongsTo para indicar la relación correcta
    }
}

