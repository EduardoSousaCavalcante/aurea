<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('produtos', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 100);
            $table->string('sku')->unique(); // novo campo SKU
            $table->text('descricao');
            $table->integer('quantidade_por_caixa');
            $table->decimal('preco', 10, 2);
            $table->integer('estoque')->default(0); // quantidade em estoque
            $table->string('imagem')->nullable();
            $table->timestamps();
        });

        // Inserir 3 produtos iniciais
        \DB::table('produtos')->insert([
            [
                'nome' => 'Caixa de Bombom',
                'sku' => 'BOM001',
                'descricao' => 'Caixa com 20 bombons sortidos.',
                'quantidade_por_caixa' => 20,
                'preco' => 29.90,
                'estoque' => 100,
                'imagem' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nome' => 'Barra de Chocolate',
                'sku' => 'CHO001',
                'descricao' => 'Barra de chocolate ao leite 200g.',
                'quantidade_por_caixa' => 10,
                'preco' => 15.50,
                'estoque' => 50,
                'imagem' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nome' => 'Pacote de Balas',
                'sku' => 'BAL001',
                'descricao' => 'Pacote com 100 balas sortidas.',
                'quantidade_por_caixa' => 100,
                'preco' => 9.99,
                'estoque' => 200,
                'imagem' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('produtos');
    }
};