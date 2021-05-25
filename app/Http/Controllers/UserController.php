<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends TraitController
{
    public function index(){
        $user = User::all();
       // return response()->json(['data'=>$user],200);
       return $this->showAll($user);
    }
    public function show($id){
        $user=User::findOrFail($id);
        // if(is_null($user)){
        //     return response()->json(['data'=>'No user is found here for your id=',$id],401);
        // }
        // return response()->json(['data'=>$user],200);
        return $this->showOne($user,200);
    }
    public function store(Request $request){ 
        // $rules=[
        //     'name' =>'required',
        //     'email' =>'required|email|unique:users',
        //     'password' =>'required|password',
        // ];
        // $this->validate($request,$rules);
        // $request->validate([
        //     'name' => 'required|string|max:255',
        //     'email' => 'required|string|email|max:255|unique:users',
            
        // ]);
        $data=$request->all();
        $data['password']=bcrypt($request->password);
        $data['verified']=User::UNVERIFIED_USER;
        $data['verified']=User::generateVerifiedToken();
        $data['admin']=User::REGULAR_USER;

        $user=User::create($data);
        return response()->json(['data'=>$user],200);
    }
    public function update(Request $request,$id){
        $user=User::findOrFail($id);
        if($request->has('name')){
            $user->name=$request->name;
        }if($request->has('email') && $user->email !=$request->email){
            $user->verified=User::UNVERIFIED_USER;
            $user->verificationToken=User::generateVerifiedToken();
            $user->email=$request->email;
        }if($request->has('password')){
            $user->password=bcrypt($request->password);
        }if($request->has('admin')){
            if(!$user->isverified()){
                return response()->json(['error' =>'only admin users can change','code'=>409],409);
            }
            $user->admin=$request->admin;
        }
        if(!$user->isDirty()){
           // return response()->json(['error'=>'You need to specify different values for update','code'=>422],422);
           return $this->errorResponse('You need to specify different values for update',422);
        }
        $user->save();
        //return response()->json(['data'=>$user],200);
        return $this->showOne($user);

    }
    public function destroy($id){
        $user=User::findOrFail($id);
        $user->delete();
        return $this->showOne($user);
    }
}
