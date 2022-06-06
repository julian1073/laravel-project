<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Ciudad;
use App\Models\Cuenta;
use App\Models\Sucursal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $usuarios = new User();
        $usuarios = User::select('users.*')
                        ->where('rol', 3)
                        ->with([
                            'ciudad',
                            'sucursal'
                        ])
                        ->get();
        return $usuarios;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $emailValidation = User::select('users.name')
                                ->where('email', $request->email)
                                ->get();

        if (count($emailValidation) > 0) {
            return 0;
        }
        else {
            $usuario = new User();
            $usuario->name = $request->name;
            $usuario->email = $request->email;
            $usuario->password = Hash::make($request->password);
            $usuario->rol = $request->rol;
            $usuario->apellidos = $request->apellidos;
            $usuario->numero_identificacion = $request->numero_identificacion;
            $usuario->direccion = $request->direccion;
            $usuario->ciudad_id = $request->ciudad_id;
            $usuario->sucursal_id = $request->sucursal_id;

            if ($usuario->save()) {
                $cuenta = new Cuenta();
                $first = strval(mt_rand(100, 999));
                $second = strval(mt_rand(1000, 9999));
                $tird = strval(mt_rand(1000, 9999));
                $fourt = strval(mt_rand(1000, 9999));
                $cuenta->numero_cuenta =  $first . $second . $tird . $fourt;
                $cuenta->saldo = 0;
                $cuenta->user_id = $usuario->id;
                $cuenta->save();
                if ($cuenta)
                    return 1;
                else
                    return 2;
            } else {
                return 2;
            }
        }

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
        $usuario = User::find($id);
        $usuario->name = $request->name;
        $usuario->rol = $request->rol;
        $usuario->apellidos = $request->apellidos;
        $usuario->numero_identificacion = $request->numero_identificacion;
        $usuario->direccion = $request->direccion;
        $usuario->ciudad_id = $request->ciudad_id;
        $usuario->sucursal_id = $request->sucursal_id;
        if ($usuario->save())
            return true;
        else
            return false;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        if ($user->delete())
            return true;
        else
            return false;
    }

    public function usuariosHome()
    {
    	return view("usuarios");
    }

    public function obtenerCiudades()
    {
        $ciudades = Ciudad::get(['id as value', 'nombre as label']);
        return $ciudades;
    }

    public function obtenerSucursales()
    {
        $sucursales = Sucursal::get(['id as value', 'nombre as label']);
        return $sucursales;
    }
}
