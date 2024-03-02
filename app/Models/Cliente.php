<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;
    protected $fillable = ['persona_id'];

    // relacion uno a uno inversa
    public function persona() {
        return $this->belongsTo(Persona::class);
    }

    // relacion uno a muchos
    public function ventas() {
        return $this->hasMany(Venta::class);
    }
}
