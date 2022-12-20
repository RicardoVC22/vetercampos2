<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\role_has_permissions;
use App\Models\User;
use App\Models\Repartidor;
use App\Models\Empleado;
use App\Models\Cliente;
use Illuminate\Support\Facades\Hash;
use PhpParser\ErrorHandler\Collecting;
use Illuminate\Support\Facades\Auth;
class Administracion extends Controller
{
    protected $permisos,$roles,$user_rol,$user;


    public function __construct()
    {
        $this->middleware('auth');
        $this->user=new User();

    }
    public function index()
    {
        if (Auth::user()->hasPermissionTo('catalogo')) {
       // $roles = Role::all();
        $user = User::with('roles')->get();
        $user=$user->where('estado',1);
       // return $user;
        $datos=['usuarios' => $user];
        echo view('administracion/usuarios/index',$datos);
         }else{return "no tiene ese privilegio";
        };
    }

    public function indexROL()
    {
        $roles = Role::all();
        $roles=$roles->where('estado',1);
        $datos=['roles' => $roles];
        echo view('administracion/roles/index',$datos);
    }

    public function indexPERMISO($id)
    {
        
        $rol_permiso=role_has_permissions::all();
        $rol_permiso=$rol_permiso->where('role_id',$id);

        $permisos = Permission::all();
        $id_aux=$id;
        
        $datos=['permisos' => $permisos , 'rol_permiso'=>$rol_permiso,'id_aux'=>$id_aux];
        echo view('administracion/permisos/index',$datos);
    }

    public function indexPERFIL($id){
         

    }


    public function eliminados()
    {
       // $roles = Role::all();
       $user = User::with('roles')->get();
       $user=$user->where('estado',0);
      // return $user;
       $datos=['usuarios' => $user];
       echo view('administracion/usuarios/eliminados',$datos);  
    }
    public function eliminadosROL()
    {
        $roles = Role::all();
        $roles=$roles->where('estado',0);
        $datos=['roles' => $roles];
        echo view('administracion/roles/eliminados',$datos);
    }

    public function restaurar($id)
    {
        $user = User::all();
        $user = $user->where('id',$id)->first();
        $cliente=Cliente::all();
        $cliente=$cliente->where('id_usuario',$id)->first();
        $repartidor=Repartidor::all();
        $repartidor=$repartidor->where('id_usuario',$id)->first();
        $empleado=Empleado::all();
        $empleado=$empleado->where('id_usuario',$id)->first();
        
        if($empleado){
            $empleado->estado=1;
            $empleado->update();
        }

        if($cliente){
            $cliente->estado=1;
            $cliente->update();  
        }

        if($repartidor){
            $repartidor->estado=1;
            $repartidor->update();
        }
        $user->estado = 1;
        $user->update();
        return redirect()->to(asset('administracion'));
    }
    public function restaurarROL($id)
    {
        $role = Role::all();
        $role = $role->where('id',$id)->first();
        $role->estado = 1;
        $role->update();
        return redirect()->to(asset('administracion/roles'));
    }
       

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::all();
        $datos =['roles'=>$roles];
        echo view('administracion/usuarios/create',$datos);
    }

    public function createROL()
    {
        echo view('administracion/roles/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre'=> 'required',
            'email'=> 'required',
            'contraseña'=> 'required',
            'confirmar_contraseña'=> 'required',
        ]);
        if ($request->contraseña == $request->confirmar_contraseña){
            
            User::create([
                'name'=> $request->nombre,
                'email' => $request->email,
                'password' => Hash::make($request->contraseña),
               
            ])->assignRole($request->id_rol);
            // el id_rol no es numero es el nombre

            return redirect()->to(asset('administracion'));
        }
    }

    public function storeROL(Request $request)
    {
        $request->validate([
            'nombre'=> 'required',
        ]);
           $roleX= Role::create([
                'name'=> $request->nombre, 
            ]);

            $permiso = Permission::all();
            $permiso=$permiso->where('id',1)->first();
            $permiso->syncRoles([$roleX]);
            // el id_rol no es numero es el nombre

            return redirect()->to(asset('administracion/roles'));
        
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::with('roles')->get();
        $roles = Role::all();
        $user = $user->where('id',$id)->first();
        $datos=['usuario'=>$user,'roles'=>$roles];
        echo view('administracion/usuarios/editar',$datos);
    }
    public function editROL($id)
    {
        $role = Role::all();
        $role = $role->where('id',$id)->first();
        $datos=['roles'=>$role];
        echo view('administracion/roles/editar',$datos);
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
        $request->validate([
            'id_rol'=> 'required',
        ]);

        $user = User::all();
        $user = $user->where('id',$id)->first();
        
        $user->removeRole($request->id_rol_aux);
        $user->assignRole($request->id_rol);
        return redirect()->to(asset('administracion'));    
    }
    public function updateROL(Request $request, $id)
    {
        $request->validate([
            'nombre'=> 'required',
        ]);

        $role = Role::all();
        $role = $role->where('id',$id)->first();
     
        $role->name = $request->nombre;
        $role->update();
        
        return redirect()->to(asset('administracion/roles'));    
    }

    public function updatePERMISO(Request $request, $id)
    { 
        $num=collect($request->permisos);
        $n=count($num);

        if($n != 0){
        $roles=Role::all(); // se llama todos los roles
        $roles=$roles->where('id',$id)->first(); // invocamos al rol a cambiar
        $permiso=Permission::whereIn('id', $request->permisos)->get(); // traemos todos los registros con un array de $reques q contiene id de permisos
        $roles->syncPermissions($permiso);// metodo para asiganr array de permisos a un rol

        return redirect()->to(asset('administracion/roles'));
        }else{
            return "no selecciono ningun permiso";
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
        $user = User::all();
        $user = $user->where('id',$id)->first();
        $cliente=Cliente::all();
        $cliente=$cliente->where('id_usuario',$id)->first();
        $repartidor=Repartidor::all();
        $repartidor=$repartidor->where('id_usuario',$id)->first();
        $empleado=Empleado::all();
        $empleado=$empleado->where('id_usuario',$id)->first();
        
        if($empleado){
            $empleado->estado=0;
            $empleado->update();
        }

        if($cliente){
            $cliente->estado=0;
            $cliente->update();  
        }

        if($repartidor){
            $repartidor->estado=0;
            $repartidor->update();
        }
        $user->estado = 0;
        $user->update();
        return redirect()->to(asset('administracion'));
    }

    public function destroyROL($id)
    {
        $role = Role::all();
        $role = $role->where('id',$id)->first();
        //$role->delete();
        $role-> estado = 0 ;
        $role->update();
        return redirect()->to(asset('administracion/roles'));
    } 
}
