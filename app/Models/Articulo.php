<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Articulo extends Model
{
    use HasFactory;

    protected $table = 'articulos';

    protected $fillable = [
        'titulo',
        'contenido',
        'categoria_id',
        'usuario_id'];
    public function comentarios(){
        return $this->hasMany(Comentario::class, 'articulo_id');
    }

    public function usuario(){
        return $this->belongsTo(User::class, 'usuario_id');
    }
    
        // Relación con el modelo Articulo
    public function categoria(){
        return $this->belongsTo(Articulo::class, 'categoria_id');
    }
}
