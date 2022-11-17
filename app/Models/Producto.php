<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    // N:1
    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    // N:M
    public function pedidos()
    {
        // le especicficamos que nuestra tabla relacion tiene una columna que es "cantidad"
        return $this->belongsToMany(Pedido::class)->withPivot(["cantidad"]);
    }
}
