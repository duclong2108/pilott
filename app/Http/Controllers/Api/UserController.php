<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMail;
use App\Models\Admin;
use App\Models\History;
use Carbon\Carbon;

class UserController extends Controller
{
  public function checkEmailMobile(Request $request){
    $data=$request->all();
    if(!isset($data['value'])){
      return response()->json(['statusCode'=>403, 'message' => 'Điền thông tin đăng nhập']);
    }else if(User::where('email', $data['value'])->count()>0){
      return response()->json(['statusCode'=>200, 'message' => 'Tiếp tục']);
      
    }else if(User::where('mobile', $data['value'])->count()>0){
      
      return response()->json(['statusCode'=>200, 'message' => 'Tiếp tục']);
    }else{
      return response()->json(['statusCode'=>403, 'message' => 'Email hoặc số điện thoại không tồn tại']);
    }
  }
  public function login(Request $request)
  {
    $data=$request->all();
    
    if(!isset($data['password'])){
      return response()->json(['statusCode'=>403, 'message' => 'Chưa nhập mật khẩu']);
    }else{
      if (Auth::attempt(['email' => $data['value'], 'password' =>$data['password']])||Auth::attempt(['mobile' => $data['value'], 'password' =>$data['password']])) {
        $user = User::find(Auth::user()->id);
        $token = $user->createToken('MyApp')->accessToken;
        $user->update(['token' => $token]);
        return response()->json(['statusCode'=>200, 'message' => 'Đăng nhập thành công', 'data' => ['token'=>$token]]);
      }
      else{
        return response()->json(['statusCode'=>404, 'message' => 'Đăng nhập sai']);
      }
    }
  }
  public function register(Request $request)
  {
    $data = $request->all();
    $validator = Validator::make($data, [
      'email' => 'required|unique:users,email',
      'mobile' => 'required|unique:users,mobile|numeric',
      'password' => 'required',
      'confirm_password' => 'same:password'
    ]);

    if ($validator->fails()) {
      return response()->json(['statusCode' => 403, 'message' => 'Thông tin đăng ký không đúng, vui lòng thử lại']);
    } else {
      $data['password'] = Hash::make($data['password']);

      $user = User::create($data);
      Auth::login($user);
      $token =  $user->createToken('MyApp')->accessToken;
      $data['token']=$token;
      $user->update($data);
      return response()->json(['statusCode'=> 200, 'message' => 'Đăng ký thành công', 'token' => ['token'=>$token]]);
    }
  }
  public function sendEmail(Request $request)
  {
    $data=$request->all();
    
    if($request->isMethod('post')){
      if ((User::where('email', $data['email'])->count()) >0) {
        $otp = rand(100000, 999999);
        $user = User::where('email', $data['email'])->first();
        

        $mail_details = [
          'email' => $data['email'],
          'otp' => $otp
        ];
        Mail::to($data['email'])->send(new SendMail($mail_details));
        $user->update(['otp' => $otp, 'updated_at'=>date('Y-m-d H:i:s', strtotime(Carbon::now()))]);
        return response()->json(['statusCode' => 200, 'message' => 'OTP gửi thành công']);
        
      } else {
        return response()->json(['statusCode'=> 401, 'message' => 'Email không tồn tại']);
      }
    }
    if ((User::where('email', $data['email'])->count()) >0) {
      $user = User::where('email', $data['email'])->first();
      if(strtotime('+1 minutes',strtotime($user['updated_at']))-(strtotime(Carbon::now()))>=0){
        return response()->json(['statusCode'=>200, 'time_count_down'=>strtotime('+1 minutes',strtotime($user['updated_at']))-(strtotime(Carbon::now()))]);
      }else{
        $user->update(['otp'=>'aaaaaaa']);
        return response()->json(['statusCode'=>200, 'message'=>'Hết thời gian!']);
      }
    }else{
      return response()->json(['statusCode'=> 401, 'message' => 'Email không tồn tại']);
    }
  }
  public function checkOtp(Request $request)
  {
    $data=$request->all();
    if (User::where('email', $data['email'])->where('otp', $data['otp'])->count() > 0) {
      return response()->json(['statusCode' => 200, 'message' => 'Nhập đúng mã OTP']);
    } else {
      return response()->json(['statusCode' => 405, 'message' => 'Nhập sai OTP']);
    }
  }
  public function resetPassword(Request $request)
  {
    $data = $request->all();
    $validator = Validator::make($data, [
      'password' => 'required',
      'confirm_password' => 'same:password'
    ]);
    if ($validator->fails()) {
      return response()->json(['statusCode' => 401, 'message' => 'Mật khẩu với nhập lại mật khẩu không giống nhau']);
    } else {
      User::where('email', $data['email'])->update(['password' => Hash::make($data['password'])]);
      return response()->json(['statusCode' => 200, 'message' => 'Đổi mật khẩu thành công']);
    }
  }
  public function logout()
  {
    Auth::user()->token()->revoke();
    return response()->json(['statusCode' => 200, 'message' => 'Đăng xuất thành công']);
  }
  public function sidebar(){
    if(Auth::check()){
      return response()->json(['statusCode'=>200, 'data'=>['name'=>Auth::user()->name, 'mobile'=>Auth::user()->mobile]]);
    }else{
      return response()->json(['statusCode'=>200, 'data'=>['mobile'=>Auth::user()->mobile]]);
    }
  }
  public function profile(Request $request){
    $data=$request->all();
    if($request->isMethod('post')){
      $user=User::find(Auth::user()->id);
      $validator=Validator::make($data['mobile'],[
        'mobile'=>'numeric|digits:10'
      ]);
      $validator1=Validator::make($data['image'],[
        'image' => 'mimes:jpeg,jpg,png,gif|required|max:10000'
      ]);
      if(isset($data['image'])){
        if($validator1->fails()){
          return response()->json(['statusCode'=>403, 'message'=>'Lỗi ảnh']);
        }else{
          $image = $request->file('image');
            $reimage = 'imgs/'.time() . '.' . $image->getClientOriginalExtension();
            $dest = public_path('/imgs');
            $image->move($dest, $reimage);
            $data['image']=$reimage;
            $user->update(['image'=>$data['image']]);
            return response()->json(['statusCode'=>200, 'message'=>'Cập nhật ảnh thành công']);
        }
      }
      else if(isset($data['name'])){
        $user->update(['name'=>$data['name']]);
        return response()->json(['statusCode'=>200, 'message'=>'Cập nhật tên thành công']);
      }else if(isset($data['mobile'])){
        if($validator->fails()){
          return response()->json(['statusCode'=>403, 'message'=>'Điện thoại chưa chính xác']);
        }else{
          $user->update(['mobile'=>$data['mobile']]);
          return response()->json(['statusCode'=>200, 'message'=>'Cập nhật số điện thoại thành công']);
        }
      }else if(isset($data['password'])){
        if(Hash::check($data['password'], $user['password'])&&$data['new_password']==$data['confirm_password']){
          $user->update(['password'=>Hash::make($data['new_password'])]);
          return response()->json(['statusCode'=>200, 'message'=>'Cập nhật thành công']);
        }else{
          return response()->json(['statusCode'=>403, 'message'=>'Mật khẩu cũ chưa chính xác hoặc mật khẩu mới với mật khẩu nhập lai chưa giống!']);
        }
      }
    }
    return response()->json(['statusCode'=>200, 'data'=>['email'=>Auth::user()->email, 'mobile'=>Auth::user()->mobile]]);
  }
  public function money(){
    if(Auth::check()){
      $histories=History::where('user_id', Auth::user()->id)->orderBy('id', 'desc')->get();
      $xxx=array();
      foreach($histories as $history){
        array_push($xxx, ['id'=>$history['id'], 'money'=>$history['money'], 'created_at'=>date('H:i d/m/Y',strtotime($history['created_at']))]);
      }
      return response()->json(['statusCode'=>200, 'data'=>['money'=>Auth::user()->money, 'history'=>$xxx]]);
    }else{
      return response()->json(['statusCode'=>200, 'data'=>['money'=>0]]);
    }
  }
  public function recharge(Request $request){
    return response()->json(['statusCode'=>200, 'data'=>['name'=>Admin::first()->name, 'account'=>Admin::first()->account, 'bank'=>Admin::first()->bank]]);
  }
}
