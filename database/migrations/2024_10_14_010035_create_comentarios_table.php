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
            $table->foreign('articulo_id')->references('id')->on('articulos')->onDelete('cascade');

            $table->unsignedBigInteger('usuario_id');  // Define el campo usuario_id como clave foránea
            // Clave foránea que apunta a la tabla 'users'
            $table->foreign('usuario_id')->references('id')->on('users')->onDelete('cascade');

            $table->timestamps(); 
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
