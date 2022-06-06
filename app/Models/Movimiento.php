<?php

namespace App\Models;

use App\Models\TipoMovimiento;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Movimiento extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'movimientos';
    protected $primaryKey= 'id';
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'fecha',
        'tipo_id',
        'cuenta_id',
        'detalle'
    ];

    public $timestamps = true;

    public function tipo()
    {
        return $this->belongsTo(TipoMovimiento::class, 'tipo_id');
    }
}
