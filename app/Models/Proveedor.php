<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    use HasFactory;
    protected $fillable = ['persona_id'];

    // relacion uno a uno inversa
    public function persona() {
        return $this->belongsTo(Persona::class);
    }

    // relacion uno a muchos
    // metodo principal entre proveedor y compra
    public function compras() {
        return $this->hasMany(Compra::class);
    }


}
