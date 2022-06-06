<?php

namespace App\Models;

use App\Models\Ciudad;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sucursal extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'sucursales';
    protected $primaryKey= 'id';
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'nombre',
        'direccion',
        'telefono',
        'gerente',
        'ciudad_id'
    ];

    public $timestamps = true;

    public function ciudad()
    {
        return $this->belongsTo(Ciudad::class, 'ciudad_id');
    }
}
