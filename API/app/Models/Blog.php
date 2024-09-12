<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;

    protected $fillable = ['direccion_logo', 'titulo', 'contenido', 'user_id'];

    /**
     * Relación: Un blog pertenece a un usuario.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
