<?php

namespace App\Http\Controllers;

use App\Models\Cuenta;
use App\Models\Movimiento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CuentasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id = Auth::id();
        $cuenta = Cuenta::where('user_id', $id)
                        ->with('movimientos')
                        ->first();
        return $cuenta;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $cuenta = Cuenta::find($id);
        if ($request->tipo_id == 1) {
            $cuenta->saldo = $cuenta->saldo + $request->detalle;
        }
        else {
            $cuenta->saldo = $cuenta->saldo - $request->detalle;
        }
        if ($cuenta->save()) {
            $movimiento = new Movimiento();
            $movimiento->fecha = $request->fecha;
            $movimiento->tipo_id = $request->tipo_id;
            $movimiento->cuenta_id = $cuenta->id;
            $movimiento->detalle = $request->detalle;
            $movimiento->save();
            if ($movimiento->save())
                return true;
            else
                return false;
        }
        else {
            return false;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function cuentasHome()
    {
    	return view("cuentas");
    }
}
