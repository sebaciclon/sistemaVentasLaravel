<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    use HasFactory;
    protected $fillable = ['fecha_hora', 'nro_comprobante', 'total', 'estado', 
    'cliente_id', 'user_id', 'comprobante_id'];

    //protected $guarded = ['id'];

    // relacion uno a muchos inversa
    public function cliente() {
        return $this->belongsTo(Cliente::class);
    }

    // relacion uno a uno
    public function user() {
        return $this->belongsTo(User::class);
    }

    // relacion uno a muchos inversa
    public function comprobante() {
        return $this->belongsTo(Comprobante::class);
    }

    // relacion muchos a muchos
    public function productos() {
        return $this->belongsToMany(Producto::class)->withTimestamps()
        ->withPivot('cantidad', 'precio_venta', 'descuento');
    }
}
