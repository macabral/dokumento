<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Documentos extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo',
        'descricao',
        'datadoc',
        'user_id',
        'nomearq',
        'docsize',
        'notas'
    ];

}
