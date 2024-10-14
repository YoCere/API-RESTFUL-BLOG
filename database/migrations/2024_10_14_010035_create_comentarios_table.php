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
        Schema::create('comentarios', function (Blueprint $table) {
           
            $table->id(); 
            $table->text('contenido'); 
            $table->unsignedBigInteger('articulo_id'); 
            $table->unsignedBigInteger('usuario_id'); 
            $table->timestamp('fecha_creacion')->useCurrent(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comentarios');
    }
};
