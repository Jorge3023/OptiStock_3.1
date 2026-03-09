<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
protected $fillable = [
    'nombre',
    'codigo_barras', 
    'stock',
    'precio',
    'creado_por',
    'cargo',
    'estado',
];
}
