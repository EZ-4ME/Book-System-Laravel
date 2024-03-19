<?php

namespace App\Http\Controllers;

use App\Models\book;
use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    //user table
    public function index(): View{
        return view('user.index', [
            'users' => User::all()
        ]);
    } 

    //user detail
    public function show(): View{
        return view('user.show', [
            'users' => User::all()
        ]);
    } 

    //add user form
    public function AddUserForm(): View{
        return view('user.addForm');
    } 

    //add User
    public function AddUser(Request $req): Redirect{

        $validator = Validator::make($req->all(), [
            'name'     => 'required|string|max:255',
            'email'     => 'required',
            'password'   => 'required',
        ]);
        
        // $validator = $req->validate([
        //     'name' => ['required', 'string', 'max:255'],
        //     'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
        //     'password' => ['required', 'confirmed', Password::defaults()],
        // ]);
        
        if(!$validator->fails()){
            $user = new User();

            $existed = $user->where('email',$req->email);
    
            if(!$existed){
                $user->name = $req->name;
                $user->email = $req->email;
                $user->password = Hash::make($req->password);
                $Status = $user->saveOrFail;
                if($Status){
                    return redirect()->route('user.index')
                        ->withSuccess('New user is added successfully.');
                }
                return redirect()->route('user.index')
                ->with('error','added Fail!');
            }
            return redirect()->route('user.index')
            ->with('error','user Existed!');
        }
        return redirect()->route('user.index')
        ->with('error','Invalid Input!');
    } 

    //add user form
    public function EditUserForm(): View{
        return view('user.editForm');
    } 

    //add User
    public function EditUser(Request $req): Redirect{
        return redirect()->route('products.index')
                ->withSuccess('Updated is successfully.');
    } 
}
