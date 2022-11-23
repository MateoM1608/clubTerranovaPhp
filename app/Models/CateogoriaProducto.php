<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CateogoriaProducto extends Model
{
    use HasFactory;

    protected $table = 'Categoria_producto';

    protected $fillable= [
        'CategoriaId',
        'ProductoId'
    ];

}
