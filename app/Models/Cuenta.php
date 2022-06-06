<?php

namespace App\Models;

use App\Models\Movimiento;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cuenta extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'cuentas';
    protected $primaryKey= 'id';
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'numero_cuenta',
        'saldo',
        'user_id'
    ];

    public $timestamps = true;

    public function movimientos()
    {
        return $this->hasMany(Movimiento::class, 'cuenta_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
