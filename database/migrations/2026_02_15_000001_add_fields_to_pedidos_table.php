<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('pedidos', function (Blueprint $table) {
            $table->string('chave_aleatoria', 12)->unique()->after('id');
            $table->foreignId('id_cliente')->nullable()->constrained('clientes', 'id')->onDelete('set null')->after('chave_aleatoria');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pedidos', function (Blueprint $table) {
            $table->dropForeignIdFor(Cliente::class, 'id_cliente');
            $table->dropColumn(['chave_aleatoria', 'id_cliente']);
        });
    }
};
