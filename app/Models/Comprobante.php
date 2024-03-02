<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comprobante extends Model
{
    use HasFactory;
    protected $fillable = ['tipo_comprobante', 'estado'];

    // relacion uno a muchos
    public function compras() {
        return $this->hasMany(Compra::class);
    }

    // relacion uno a muchos
    public function ventas() {
        return $this->hasMany(Venta::class);
    }
}
