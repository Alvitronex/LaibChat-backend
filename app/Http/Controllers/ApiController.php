<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function mostrar_usuarios()
    {
        $usuarios = User::all();
        return json_encode($usuarios);
    }
    public function mostrar_un_usuarios($user_id)
    {
        // $usuarios = User::find($user_id);
        $usuarios = User::where('id', '=', $user_id)->first();
        return json_encode($usuarios);
    }
    public function mostrar_un_usuarios2(Request $request)
    {
        $usuarios = User::find($request->user_id);
        return json_encode($usuarios);
    }
    public function crear(Request $request)
    {
        $request ->validate([
            'name' => 'required',
            'email' => 'required|unique:users,email',
            'password' => 'required'
        ]);
        $usuario = new User();
        $usuario->name  = $request->name;
        $usuario->email = $request->email;
        $usuario->password = bcrypt($request->password);
        $usuario->save();

        $mensaje = "usuario creado exitosamente!!"; 
        return json_encode($mensaje);
    }
}
