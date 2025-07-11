<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use function Laravel\Prompts\password;

class UsuarioController extends Controller
{
    // Lógica para listar usuarios
    public function index()
    {
        $usuarios = User::with('rol')->get(); // Carga usuarios + roles
        return view('backoffice.usuarios.index', compact('usuarios'));
    }

    // Lógica para resetear la clave de un usuario
    public function resetearClave($id)
    {
        $usuario = User::findOrFail($id); // Encuentra el usuario por ID

        $nuevaClave = strtolower($usuario->name) . Carbon::now()->year; // Genera una nueva clave nombre de usuario + año actual
        $usuario->password = Hash::make($nuevaClave);
        $usuario->save();

        // Redirige a la lista de usuarios con un mensaje de éxito
        return redirect()->route('backoffice.usuarios.index')
            ->with('success', 'Clave actualizada con éxito del usuario: ' . $usuario->email);
    }

  public function crearUsuario(){
        // Aquí podrías implementar la lógica para crear un nuevo usuario
        // Por ejemplo, mostrar un formulario para ingresar los datos del nuevo usuario
        return view('backoffice.usuarios.crear');
    }

    // Lógica para almacenar un nuevo usuario
    public function store(Request $request){

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'id_rol' => 'required|exists:roles,id',
        ]);

        $data = $request->only(['name', 'email', 'id_rol']);
        $data['password'] = Hash::make($request->password);
        User::create($data);

        return redirect()->route('backoffice.usuarios.index')
            ->with('success', 'Usuario creado correctamente.');
    }

    // Lógica para eliminar un usuario y sus reservas
    public function destroy($id)
    {
        $usuario = User::findOrFail($id);

        // Elimina todas sus reservas antes de eliminar al usuario
        $usuario->reservas()->delete();

        $usuario->delete();

        // Redirige a la lista de usuarios con un mensaje de éxito
        return redirect()->route('backoffice.usuarios.index')
            ->with('success', 'Usuario y sus reservas eliminados correctamente.');
    }
}
