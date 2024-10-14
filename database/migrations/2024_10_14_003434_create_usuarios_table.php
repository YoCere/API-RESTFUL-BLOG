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
        Schema::create('usuarios', function (Blueprint $table) {
          
            $table->increments('id'); 
            $table->string('nombre', 100); 
            $table->string('email', 150); 
            $table->string('contraseña', 255); 
            $table->enum('rol', ['admin', 'editor', 'usuario']); 
            $table->timestamp('fecha_registro')->useCurrent(); 
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};
