<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        // Criar a tabela 'carousels'
        Schema::create('carousels', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->string('descricao')->nullable();
            $table->string('imagem'); // nome da imagem
            $table->timestamps();
        });

        // Inserir 3 carousels
        DB::table('carousels')->insert([
            [
                'titulo' => 'Laranja e roxo',
                'descricao' => 'Gosto',
                'imagem' => 'laranja_roxo.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'titulo' => 'Vermelho e Marrom',
                'descricao' => 'Gosto Bastante',
                'imagem' => 'vermelho_marrom.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'titulo' => 'Azul e Rosa',
                'descricao' => 'Gosto Também',
                'imagem' => 'azul_rosa.png',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carousels');
    }
};
