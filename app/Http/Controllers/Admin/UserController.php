<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use function PHPUnit\Framework\isNull;

class UserController extends Controller
{
    public function listUsers()
    {
        $users = User::all();
        return view('admin.user_list', compact('users'));
    }

    public function editUser(int $id){
        $user = User::find($id);
        if(!$user)
            $user = new User();
        return view('admin.user_edit', compact('user'));
    }

    public function deleteUser(int $id){
        $user = User::find($id);
        if($user)
            $user->delete();
        return $this->listUsers();
    }

    public function updateUser(int $id){
        $user = User::find($id);
        if(!$user)
            $user = new User();
        $this->validate(
            request(),[
                'name' => 'required',
                'email' => 'required|unique:users,email,'.$id,
                'password' => $id==0?'required|confirmed|min:6':'sometimes|nullable|confirmed|min:6'
            ]
        );
        $user->fill(request()->all());
        if(request('password') != "")
            $user->password = Hash::make(request('password'));

        $user->save();

        return $this->listUsers();
    }
}
