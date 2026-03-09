<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ProductoSeeder extends Seeder
{
    public function run(): void
    {
        $productos = [
            ['nombre' => 'Mouse inalámbrico Logitech M185',       'codigo_barras' => '097855065023', 'stock' => 25,  'precio' => 299.99,  'cargo' => 'Almacén',   'estado' => 'Disponible'],
            ['nombre' => 'Teclado mecánico Redragon K552',         'codigo_barras' => '610708230014', 'stock' => 15,  'precio' => 749.00,  'cargo' => 'Almacén',   'estado' => 'Disponible'],
            ['nombre' => 'Monitor Samsung 24" FHD',                'codigo_barras' => '887276630213', 'stock' => 8,   'precio' => 3299.00, 'cargo' => 'Bodega',    'estado' => 'Disponible'],
            ['nombre' => 'Audífonos Sony WH-1000XM4',              'codigo_barras' => '027242920859', 'stock' => 10,  'precio' => 5499.00, 'cargo' => 'Almacén',   'estado' => 'Disponible'],
            ['nombre' => 'Webcam Logitech C920',                   'codigo_barras' => '097855077224', 'stock' => 0,   'precio' => 1899.00, 'cargo' => 'Bodega',    'estado' => 'Sin existencia'],
            ['nombre' => 'SSD Kingston 480GB SATA',                'codigo_barras' => '740617298703', 'stock' => 20,  'precio' => 699.00,  'cargo' => 'Almacén',   'estado' => 'Disponible'],
            ['nombre' => 'Memoria RAM Corsair 8GB DDR4',           'codigo_barras' => '843591042031', 'stock' => 30,  'precio' => 549.00,  'cargo' => 'Almacén',   'estado' => 'Disponible'],
            ['nombre' => 'Cable HDMI 2m Basics',                   'codigo_barras' => '841710107498', 'stock' => 50,  'precio' => 149.00,  'cargo' => 'Mostrador', 'estado' => 'Disponible'],
            ['nombre' => 'Hub USB-C 7 en 1 Anker',                 'codigo_barras' => '194644060572', 'stock' => 12,  'precio' => 899.00,  'cargo' => 'Mostrador', 'estado' => 'Disponible'],
            ['nombre' => 'Laptop Stand aluminio ajustable',        'codigo_barras' => '756063640092', 'stock' => 3,   'precio' => 459.00,  'cargo' => 'Bodega',    'estado' => 'Disponible'],
            ['nombre' => 'Mousepad XL Redragon P003',              'codigo_barras' => '610708390035', 'stock' => 18,  'precio' => 199.00,  'cargo' => 'Mostrador', 'estado' => 'Disponible'],
            ['nombre' => 'Fuente de poder EVGA 600W',              'codigo_barras' => '843368041399', 'stock' => 0,   'precio' => 1299.00, 'cargo' => 'Bodega',    'estado' => 'Sin existencia'],
            ['nombre' => 'Tarjeta gráfica GTX 1650 4GB',           'codigo_barras' => '696751937225', 'stock' => 4,   'precio' => 4999.00, 'cargo' => 'Bodega',    'estado' => 'Disponible'],
            ['nombre' => 'Procesador Intel Core i5-12400',         'codigo_barras' => '735858485388', 'stock' => 6,   'precio' => 5299.00, 'cargo' => 'Bodega',    'estado' => 'Disponible'],
            ['nombre' => 'Disco duro externo WD 1TB',              'codigo_barras' => '718037862446', 'stock' => 14,  'precio' => 1099.00, 'cargo' => 'Almacén',   'estado' => 'Disponible'],
            ['nombre' => 'Silla gamer DXRacer OH/FD01',            'codigo_barras' => '811840025048', 'stock' => 2,   'precio' => 8999.00, 'cargo' => 'Bodega',    'estado' => 'Disponible'],
            ['nombre' => 'Micrófono Blue Yeti USB',                'codigo_barras' => '836213001190', 'stock' => 7,   'precio' => 3499.00, 'cargo' => 'Almacén',   'estado' => 'Disponible'],
            ['nombre' => 'Router TP-Link AC1200',                  'codigo_barras' => '845973064015', 'stock' => 0,   'precio' => 899.00,  'cargo' => 'Almacén',   'estado' => 'Sin existencia'],
            ['nombre' => 'Impresora HP LaserJet M110w',            'codigo_barras' => '196548248673', 'stock' => 5,   'precio' => 2799.00, 'cargo' => 'Bodega',    'estado' => 'Disponible'],
            ['nombre' => 'Tablet Lenovo Tab M10 Plus',             'codigo_barras' => '195892002781', 'stock' => 9,   'precio' => 4299.00, 'cargo' => 'Mostrador', 'estado' => 'Disponible'],
        ];

        foreach ($productos as $p) {
            DB::table('productos')->insert([
                'nombre'        => $p['nombre'],
                'codigo_barras' => $p['codigo_barras'],
                'stock'         => $p['stock'],
                'precio'        => $p['precio'],
                'cargo'         => $p['cargo'],
                'estado'        => $p['estado'],
                'creado_por'    => 'Jorge Garcia',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now(),
            ]);
        }
    }
}

## para ejecutar ingresa en la termional: ##
## php artisan db:seed --class=ProductoSeeder ##