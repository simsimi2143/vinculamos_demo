<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuarios extends Model
{
    use HasFactory;

    protected $table = 'usuarios';

    public $timestamps = false;

    protected $fillable = [
        'usua_nickname',
        'rous_codigo',
        'usua_email',
        'usua_email_alternativo',
        'usua_clave',
        'usua_nombre',
        'usua_apellido',
        'usua_creado',
        'usua_actualizado',
        'usua_vigente',
        'usua_usuario_mod'
    ];
}
