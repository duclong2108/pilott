<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin;
use App\Models\App;
use App\Models\Money;
use App\Models\Policy;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
class AdminController extends Controller
{
    public function login(Request $request){
        // dd(Hash::make(1));
        if($request->isMethod('post')){
            $data=$request->all();
            if(Auth::guard('admin')->attempt(['email'=>$data['email'], 'password'=>$data['password']])){
                return redirect('/admin/dashboard');
            }else{
                return redirect()->back();
            }
        }
        return View('admin.login');
    }
    public function dashboard(Request $request){
        return View('admin.dashboard');
    }
    public function logout(){
        Auth::guard('admin')->logout();
        return redirect('/admin');
    }
    public function account(Request $request){
        if($request->isMethod('post')){
            $data=$request->all();
            $validator=Validator::make($data,[
                'confirm_password'=>'same:password'
            ]);
            if($validator->fails()){
                return redirect()->back();
            }else{
                $data['password']=Hash::make($data['password']);
                Admin::find(Auth::user()->id)->update($data);
                return redirect()->back();
            }
        }
        return View('admin.account');
    }
    public function policy(Request $request){
        $policy=Policy::first();
        if($request->isMethod('post')){
            $data=$request->all();
            $policy->update($data);
            return redirect()->back();
        }
       return View('admin.policy', compact('policy'));
        
    }
    public function app(Request $request){
        $app=App::first();
        if($request->isMethod('post')){
            $data=$request->all();
            $app->update($data);
            return redirect()->back();
        }
        return View('admin.app', compact('app'));
        
    }
    public function money(Request $request){
        $money=Money::first();
        if($request->isMethod('post')){
            $data=$request->all();
            $money->update($data);
            return redirect()->back();
        }
        return View('admin.money', compact('money'));
    }
}
