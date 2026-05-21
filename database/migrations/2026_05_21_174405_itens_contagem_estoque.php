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
        Schema::create('itens_contagem_estoque', function (Blueprint $table) {
            $table->id();

            $table->foreignId('contagem_estoque_id')
                ->constrained('contagens_estoque')
                ->onDelete('cascade');

            $table->foreignId('produto_id')
                ->constrained('produtos');

            $table->integer('quantidade_sistema');

            $table->integer('quantidade_contada')
                ->nullable();

            $table->enum('situacao', [
                'A_CONFERIR',
                'CONFERIDO',
                'FALTANTE_EXCEDENTE'
            ])->default('A_CONFERIR');

            $table->text('observacao')
                ->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('itens_contagem_estoque');
    }
};
