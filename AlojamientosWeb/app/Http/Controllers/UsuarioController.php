<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('auth.login');
    }

    public function indexR(){
        return view('auth.register.register');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) // funcion para la vista register
    {

        //dd('¡El controlador se está ejecutando!', $request->all());

        // Validación básica
        $request->validate([
            'nombre_completo' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:usuarios,email'],
            'telefono' => ['required', 'string', 'max:10'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'clave_secreta' => 'nullable|string',
        ]);

        // Verificar si se intenta crear un superadmin
        $isAdminAttempt = $request->filled('clave_secreta');
        $isSuperAdmin = false;

        if($isAdminAttempt){
            $email = $request->email;
            $adminKey = $request->clave_secreta;
            $expectedKey = env('SUPERADMIN_KEY');

            //validar el correo es @admin
            if(!str_ends_with($email, '@admin.com')){
                throw ValidationException::withMessages([
                    'email' => 'Solo los correos que terminan en @admin pueden ser superadmin.',
                ]);
            }

            //validar clave secreta
            if($adminKey !== $expectedKey){
                throw ValidationException::withMessages([
                    'clave_secreta' => 'La clave de superadmin es incorrecta.',
                ]);
            }

            $isSuperAdmin = true;
        }else{
            // Si no se envió admin_key, asegurarse de que NO sea un correo @admin
            if(str_ends_with($request->correo, '@admin.com')){
                throw ValidationException::withMessages([
                    'email' => 'Este correo requiere una clave de superadmin.',
                ]);
            }
        }

        $createuser = new Usuario;
        $createuser->nombre_completo = $request->nombre_completo;
        $createuser->password = Hash::make($request->password);
        $createuser->telefono = $request->telefono;
        $createuser->email = $request->email;
        $createuser->is_superadmin = $isSuperAdmin;

        //dd($createuser);
        $createuser->save();

        return back()->with('mensaje', 'Usuario Creado!!');
    }

    public function login(Request $request){
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if(Auth::attempt([
                'email' => $request->email,
                'password' => $request->password
            ])){
            $request->session()->regenerate();
            return redirect()->intended('/home');
        }

        //dd('Bienvenido');

        return back()->withErrors([
            'email' => 'Las credenciales no son correctas'
        ]);
    }

    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/home');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Usuario $usuario)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Usuario $usuario)
    {
        //
    }
}
