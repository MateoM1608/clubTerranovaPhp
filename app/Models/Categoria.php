<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Producto;

class Categoria extends Model
{
    use HasFactory;

    protected $table = 'Categorias';

    protected $fillable = [
        'nombre'
    ];

    public function Productos()
    {
        return $this->belongsToMany(Producto::class, 'Categoria_producto','CategoriaId','ProductoId');
    }
}
