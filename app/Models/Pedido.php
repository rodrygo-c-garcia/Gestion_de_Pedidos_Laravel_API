<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;
    // N:M
    public function productos()
    {
        // le especicficamos que nuestra tabla relacion tiene una columna que es "cantidad"
        return $this->belongsToMany(Producto::class)->withPivot(["cantidad"]);
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }
    // Un pedido puede generar un unico usuario 
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
