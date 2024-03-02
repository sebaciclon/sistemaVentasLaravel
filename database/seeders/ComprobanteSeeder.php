<?php

namespace Database\Seeders;

use App\Models\Comprobante;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ComprobanteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $c= new Comprobante();
        $c->tipo_comprobante = "Boleta X";
        $c->save();

        $c1 = new Comprobante();
        $c1->tipo_comprobante = "Factura";
        $c1->save();
    }
}
