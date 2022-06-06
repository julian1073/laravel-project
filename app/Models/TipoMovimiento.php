<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TipoMovimiento extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'tipos_movimientos';
    protected $primaryKey= 'id';
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'nombre'
    ];

    public $timestamps = true;

}
