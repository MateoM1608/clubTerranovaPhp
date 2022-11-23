<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    use HasFactory;

    protected $table = 'Ventas';

    protected $fillable = [
        'producto',
        'precio_unitario',
        'cantidad',
        'precio_total',
        'fecha',
        'usuario',
        'deleted_at',
    ];
}
