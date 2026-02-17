<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->string('cnpj')->nullable();
            $table->string('razao_social')->nullable();
            $table->string('ie')->nullable();
            $table->string('endereco')->nullable();
            $table->string('cep')->nullable();
            $table->string('apelido')->nullable();
            $table->timestamps();
        });

        // Inserir dados iniciais de clientes
        DB::table('clientes')->insert([
            [
                'cnpj' => '577439970000107',
                'razao_social' => 'Vitor da Silva Oliveira',
                'ie' => '135928126114',
                'endereco' => 'Rua Mariano Galvão Bueno Trigueirinho, 5 - Parque Guarni',
                'cep' => '08235330',
                'apelido' => 'Lucas X Luciano',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'cnpj' => '631889070000146',
                'razao_social' => 'mercado Mix Lisboa LTDA',
                'ie' => '156335338119',
                'endereco' => 'Rua Dr Jose Martins Lisbo, 1203, Lj 02 - Vila Mara',
                'cep' => '08081010',
                'apelido' => 'Mercado lisboa',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'cnpj' => '637826440000107',
                'razao_social' => 'Mercado NovoLar Premium LTDA',
                'ie' => '156900601111',
                'endereco' => 'Rua Dr josé Artthur Nova, 2385, Parque Paulistano',
                'cep' => '08090000',
                'apelido' => 'Mercado Novo Lar',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};
