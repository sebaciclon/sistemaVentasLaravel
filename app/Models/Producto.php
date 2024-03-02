<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Producto extends Model
{
    use HasFactory;
    protected $fillable = ['nombre', 'codigo', 'descripcion', 'fecha_vencimiento', 'img_path', 
    'estado', 'stock', 'categoria_id'];

    public function hanbleUploadImage($image) {
        $file = $image;
        $name = time() . $file->getClientOriginalName();
        //$file->move(public_path().'/img/productos/', $name);
        Storage::putFileAs('/public/productos/',$file,$name,'public');
        return $name;
    }

    // relacion muchos a muchos
    public function compras() {
        return $this->belongsToMany(Compra::class)->withTimestamps()
        ->withPivot('cantidad', 'precio_compra', 'porcentaje_ganancia', 'precio_venta', 'compra_id', 'producto_id');
    }

    // relacion muchos a muchos
    public function ventas() {
        return $this->belongsToMany(Venta::class)->withTimestamps()
        ->withPivot('cantidad', 'precio_venta', 'descuento');
    }

    // relacion uno a muchos inversa
    public function categoria() {
        return $this->belongsTo(Categoria::class);
    }
}
