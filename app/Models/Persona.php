<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    use HasFactory;
    protected $fillable = ['nombre', 'direccion', 'telefono', 'estado'];

    // en relaciones uno a uno, el metodo principal de relacion se ubica en el modelo que
    // no tenga la llave foranea del otro (en singular)

    // para relaciones uno a muchos, el metodo principal de relacion se ubica en el modelo que
    // no tenga la llave foranea del otro (en plural y singular)

    // para relaciones muchos a muchos, el metodo principal de relacion se ubica en ambos 
    // modelos (plural)

    // relacion uno a uno
    // en persona y proveedor la llave foranea la tiene proveedor, asi que este es el
    // metodo principal entre persona y proveedor
    public function proveedor() {
        return $this->hasOne(Proveedor::class);
    }

    // relacion uno a uno
    // en persona y cliente la llave foranea la tiene cliente, asi que este es el
    // metodo principal entre persona y cliente
    public function cliente() {
        return $this->hasOne(Cliente::class);
    }
}
