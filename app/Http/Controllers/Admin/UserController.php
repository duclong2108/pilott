<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\History;
use App\Models\Money;
use App\Models\User;
use App\Models\Winner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
  public function index()
  {
    $users = User::all();
    return View('admin.user.index', compact('users'));
  }
  public function recharge(Request $request, $user_id){
    $history=History::where('user_id', $user_id)->orderBy('id','desc')->first();
    $history->update(['status'=>1]);
    User::find($user_id)->update(['money'=>Auth::user()->money+$history['money']*Money::first()->coin]);
    return redirect()->back();
  }
  public function betUser(){
    $winners=Winner::orderBy('id', 'desc')->get();
    return View('admin.user.bet', compact('winners'));
  }
  public function countDate(Request $request){
    if($request->ajax()){
      $data=$request->all();
      $count_date=Winner::where('created_at', date('Y-m-d', strtotime($data['date'])))->get()->count();
      return response()->json(['status'=>1, 'count_date'=>$count_date]);
    }
  }
}