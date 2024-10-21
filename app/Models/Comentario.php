<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comentario extends Model
{
    use HasFactory;

    
    protected $table = 'comentarios';

    protected $fillable = [
        'contenido',
        'articulo_id',
        'usuario_id'];

    public function usuario(){
        return $this->belongsTo(User::class, 'usuario_id');
    }
    
        // Relación con el modelo Articulo
    public function articulo(){
        return $this->belongsTo(Articulo::class, 'articulo_id');
    }
}
