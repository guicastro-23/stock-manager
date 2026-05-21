<?php

namespace Database\Seeders;

use App\Models\Produto;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProdutoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
     
        Produto::create([
            'codigo_sistema' => 'PROD-001',
            'nome' => 'Notebook Dell Inspiron 15',
        ]);

        Produto::create([
            'codigo_sistema' => 'PROD-002',
            'nome' => 'Mouse Logitech MX Master 3',
        ]);

        Produto::create([
            'codigo_sistema' => 'PROD-003',
            'nome' => 'Teclado Mecânico Keychron K2',
        ]);

        Produto::create([
            'codigo_sistema' => 'PROD-004',
            'nome' => 'Monitor LG UltraWide 29',
        ]);

        Produto::create([
            'codigo_sistema' => 'PROD-005',
            'nome' => 'Webcam Logitech C920',
        ]);

        Produto::create([
            'codigo_sistema' => 'PROD-006',
            'nome' => 'Headset HyperX Cloud II',
        ]);

        Produto::create([
            'codigo_sistema' => 'PROD-007',
            'nome' => 'SSD Samsung 1TB',
        ]);

        Produto::create([
            'codigo_sistema' => 'PROD-008',
            'nome' => 'Memória RAM DDR4 16GB',
        ]);

        Produto::create([
            'codigo_sistema' => 'PROD-009',
            'nome' => 'Hub USB-C 7 portas',
        ]);

        Produto::create([
            'codigo_sistema' => 'PROD-010',
            'nome' => 'Suporte para Notebook',
        ]);



    }
}
