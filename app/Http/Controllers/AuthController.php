<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function generateToken(Request $request)

    {

        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'device_name' => 'required',
        ]);


        $user = User::where('email', $request->email)->first();


        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'credenciales incorrectas',
                'errors' => [
                    'email' => ['Datos Incorrectos'],
                ]
            ]);
        }
        return $user->createToken($request->device_name)->plainTextToken;
    }

    public function mostrar_usuario()
    {
        $usuarios = User::all();
        return json_encode($usuarios);
    }
    public function crear(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users,email',
            'phone' => 'required',
            'password' => 'required'
        ]);
        $usuario = new User();
        $usuario->name  = $request->name;
        $usuario->email = $request->email;
        $usuario->phone = $request->phone;
        $usuario->password = bcrypt($request->password);
        $usuario->save();

        $mensaje = "usuario creado exitosamente!!";
        return json_encode($mensaje);
    }
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string',
            'password' => 'required|string|min:8',
        ]);
        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'password' => Hash::make($request->input('password')),
        ]);
        // $mensaje = "usuario creado exitosamente!!";
        // return json_encode($mensaje);
        return $user->createToken('Authtoken')->plainTextToken;
    }
}
