<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Hash;
use Illuminate\Support\Facades\Auth;
#use Spatie\Permission\Models\Role;
#use Spatie\Permission\Models\Permission;
class UsersController extends Controller
{

    function __construct()
    {
        //$this->middleware('permission:role-list|role-create|role-edit|role-delete', ['only' => ['index', 'store']]);
        /*$this->middleware('permission:role-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:role-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:role-delete', ['only' => ['destroy']]); */
    }

    public function index()
    {
        $users = User::get();
        //$subadmin = User::where('role_id',2)->get();
        return view('admin.users.index',compact('users'));
    }

    public function delete(Request $request)
    {

        $user = User::find($request->id)->delete();
       
    	return response()->json(['success' => true, 'message' => 'User deleted succesfully ']);
    }

    public function subadmin()
    {
        $roles = Role::where('status',1)->get();

    	return view('admin.users.subadmin',compact('roles'));
    }

    public function store(Request $request)
    {
         $subadmin = new User;
         $subadmin->name= $request->name;
         $subadmin->email = $request->email;
         $subadmin->password = bcrypt($request->password);
         $subadmin->role_id= $request->role;
         $subadmin->save();
   
     return redirect('admin/all-users')->with('successmsg','SubAdmin has been added successfully!');
    }

    public function adminProfile()
    {
        $user = User::where('id',Auth::user()->id)->first();
        $roles = Role::where('status',1)->get();

        return view('admin.users.admin_profile',compact('user','roles'));
    }

    public function checkOldPassword(Request $request)
    {
        
        $hashedPassword = Auth::user()->password;
        $old_password =  $request->old_password;
        if (Hash::check($old_password, $hashedPassword)) {
            $error = false;
        }
        else
        {
            $error = true;
        }
        
        return response()->json([
                "error"=>$error
            ]);
    }

     public function changeProfile(Request $request)
    {
        // dd($request->all());
        $validator = $request->validate([
            'old_password' => 'required',
            'new_password' => 'required',
            'confirm_new_password'  => 'required',
           
        ]);


        $user= User::where('id',Auth::user()->id)->first();
        // dd($user);
        if($user)
        {
           
            $hashedPassword=Auth::user()->password;
            $old_password =  $request['old_password'];
            if (Hash::check($old_password, $hashedPassword)) 
            {
                if($request['new_password'] == $request['confirm_new_password'])
                {
                     $user->password=bcrypt($request['new_password']);
                }
                
            }

            $user->name = $request->name;
            $user->email = $request->email;
            $user->role_id = $request->role;
            $user->save();
        }

        return response()->json(['success'=>true]);
       
    }
}
