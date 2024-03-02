<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    use HasFactory;
    protected $fillable = ['fecha_hora', 'nro_comprobante', 'total', 
    'comprobante_id', 'proveedor_id'];

    // relacion uno a muchos inversa
    public function proveedor() {
        return $this->belongsTo(Proveedor::class);
    }

    // relacion uno a muchos inversa
    public function comprobante() {
        return $this->belongsTo(Comprobante::class);
    }

    // relacion muchos a muchos
    public function productos() {
        return $this->belongsToMany(Producto::class)->withTimestamps()
        ->withPivot('cantidad', 'precio_compra', 'porcentaje_ganancia', 'precio_venta',
                        'compra_id', 'producto_id');
    }
}
