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
        Schema::create('contagens_estoque', function (Blueprint $table) {
            $table->id();

            $table->string('codigo')->unique();
            $table->date('data_agendada');

            $table->foreignId('responsavel_id')
                ->nullable()
                ->constrained('funcionarios');

            $table->enum('status', [
                'EM_ANDAMENTO',
                'FINALIZADA'
            ])->default('EM_ANDAMENTO');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contagens_estoque');
    }
};
