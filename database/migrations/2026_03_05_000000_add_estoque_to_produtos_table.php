<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (!Schema::hasColumn('produtos', 'estoque')) {
            Schema::table('produtos', function (Blueprint $table) {
                $table->integer('estoque')->default(0)->after('preco');
            });
        }

        // opcional: inicializar valores a partir de outra coluna ou fixos
        \DB::table('produtos')->whereNull('estoque')->update(['estoque' => 0]);
    }

    public function down()
    {
        if (Schema::hasColumn('produtos', 'estoque')) {
            Schema::table('produtos', function (Blueprint $table) {
                $table->dropColumn('estoque');
            });
        }
    }
};
