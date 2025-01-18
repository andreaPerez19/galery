<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;
    /**
     * Datos que pueden ser modificados
     */
    protected $fillable = [
        'title',
        'description',
        'image_path',
        'user_id'
    ];

    /**
     * Relacion de imagenes con usuario
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
