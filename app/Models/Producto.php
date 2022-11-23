<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Categoria;

class Producto extends Model
{
    use HasFactory;

    protected $table = 'Productos';

    protected $fillable = [
        'nombre',
        'precio',
        'cantidad'
    ];

    public function Categorias()
    {
        return $this->belongsToMany(Categoria::class, 'Categoria_producto', 'ProductoId','CategoriaId');
    }
}
