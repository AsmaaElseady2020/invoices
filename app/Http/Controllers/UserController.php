<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
//custom Spatie\Permission
use Spatie\Permission\Models\Role;
use App\User;
use DB;
use Hash;
class UserController extends Controller
{

public function index()
{
    
$data = User::orderBy('id','DESC')->paginate(5);
return view('users.show_users',compact('data'))
->with('i',(request()->input('page',1)-1)*5);

}



public function create()
{
$roles = Role::pluck('name','name')->all();
return view('users.Add_user',compact('roles'));
}

public function store(Request $request)
{
$this->validate($request, [
'name' => 'required',
'email'=> 'required|email|unique:users,email',
'password' => 'required|same:confirm-password',
//'roles'=> 'required'
]);
$input = $request->all();
$input['password'] = Hash::make($input['password']);
$user = User::create($input);
$user->assignRole($request->input('roles'));
return redirect()->route('users.index')
->with('success','User created successfully');
}



public function show($id)
{
$user = User::find($id);
return view(‘users.show’,compact(‘user’));
}




public function edit($id)
{
$user = User::find($id);
$roles = Role::pluck('name','name')->all();
$userRole = $user->roles->pluck('name','name')->all();
return view('users.edit',compact('user','roles','userRole'));
}



public function update(Request $request, $id)
{
$this->validate($request, [
'name' => 'required',
'email' => 'required|email|unique:users,email,'.$id,
'password' => 'same:confirm-password',
//'roles' => 'required'
]);
$input = $request->all();
if(!empty($input['password'])){
$input['password'] = Hash::make($input['password']);
}else{
$input = array_except($input,array('password'));
}
$user = User::find($id);
$user->update($input);
DB::table('model_has_roles')->where('model_id',$id)->delete();
$user->assignRole($request->input('roles'));
return redirect()->route('users.index')
->with('update','User updated successfully');
}


public function destroy(Request $request)
{
    $id=$request->user_id;
  $user= User::find($id) ;

$user->delete();

return redirect()->route('users.index')
->with('delete','User deleted successfully');


}








}