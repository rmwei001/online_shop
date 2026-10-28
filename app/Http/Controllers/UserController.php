<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserController extends Controller
{
    public function createUser(Request $request){
        $request->validate([
            'name'=>'required|string',
            'email'=>'required|email|unique:users,email',
            'password'=>'required|min:3|confirmed',
            'role_id'=>'required|integer|exists:roles,id',
            'user_image'=>'nullable|image|mimes:jpg,png,jpeg|maximum:2048'
        ]);

        $user = new User();
        $user-> name = $request->name;
        $user-> email = $request->email;
        $user-> password = Hash::make($request->password);
        $user-> role_id = $request->role_id;

        if($request->hasFile('user_image')){
            $filename = $request->file('user_image')->store('user-images', 'public');
        } else{$filename = null;
        }
        $user->user_image = $filename;

        try{
            $user->save();
            return response()->json([
                'message'=>'User registered successfully',
                'user'=>$user
            ], 200);
        } catch(\Exception $e){
            return response()->json([
                'message'=>'Failed to register user',
                'error'=>$e->getMessage()
            ], 500);
        }
    }

    public function readAll(){
        try{
             $users = User::all();
             return response()->json([
                'users'=>$users
             ], 200);
        }catch(\Exception $e){
            return response()->json([
                'message'=>'Failed to fetch',
                'error'=>$e->getMessage()
            ], 500);
        }
    }

       public function read($id){
        try{
             $user = User::where('id', $id)->first();
             return response()->json([
                'user'=>$user
             ], 200);
        }catch(\Exception $e){
            return response()->json([
                'message'=>'Failed to fetch',
                'error'=>$e->getMessage()
            ], 500);
        }
    } 

        public function updateUser($id,Request $request){
        $request->validate([
            'name'=>'required|string',
            'email'=>'required|email|unique:users,email',
            'password'=>'required|min:3|confirmed',
            'role_id'=>'required|integer|exists:roles,id',
            'user_image'=>'nullable|image|mimes:jpg,png,jpeg|maximum:2048'
        ]);

        $user = User::where('id', $id)->first();
        $user-> name = $request->name;
        $user-> email = $request->email;
        $user-> password = Hash::make($request->password);
        $user-> role_id = $request->role_id;

        if($request->hasFile('user_image')){
            $filename = $request->file('user_image')->store('user-images', 'public');
        } else{$filename = null;
        }
        $user->user_image = $filename;

        try{
            $user->save();
            return response()->json([
                'message'=>'User updated successfully',
                'user'=>$user
            ], 200);
        } catch(\Exception $e){
            return response()->json([
                'message'=>'Failed to update user',
                'error'=>$e->getMessage()
            ], 500);
        }
    }

    public function deleteUser($id){
        try{
            $user = User::where('id', $id)->first();
            if ($user){
                $user->delete();
                return response ()->json('Record deleted successfully');
            }
            else{
            return response()->json('Record not found');
        } 
        }catch(\Exception $e){
            return response()->json([
                'message'=>'Failed to delete',
                'error'=>$e->getMessage()
            ], 500);
        }
    }
}