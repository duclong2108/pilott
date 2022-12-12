<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Models\Game;
use App\Models\Winner;
use App\Console\Commands\scrape;
use App\Models\Money;
use Carbon\Carbon;
use DOMDocument;
use DOMXPath;
use Faker\Core\Number;
use Illuminate\Auth\Events\Validated;
use Illuminate\Support\Facades\Validator;

function WinPrize(Request $request)
{

  $httpClient = new \GuzzleHttp\Client();
  $response = $httpClient->get('https://www.minhngoc.net.vn/xo-so-truc-tiep/mien-bac.html');
  $htmlString = (string) $response->getBody();
  libxml_use_internal_errors(true);
  $doc = new DOMDocument();
  $doc->loadHTML($htmlString);
  $xpath = new DOMXPath($doc);
  #
  $titles = $xpath->evaluate('//div[@class="box_kqxs box_kqxstt_mienbac"]//div[@class="content"]//div[@class="bkqmienbac"]//table//tbody//tr//td[@class="giaidb"]//div');
  $extractedTitles = [];
  foreach ($titles as $title) {
    $extractedTitles[] = $title->textContent . PHP_EOL;

    return substr($title->textContent, -2);
  }
}
class NumberPicker extends Controller
{


  public function Bets(Request $request)
  {
    if(Auth::check()){
      if(date('H:i',strtotime(Carbon::now()))>'18:00'){
        return response()->json(['statusCode'=>500, 'message'=>'Hết thời gian đặt xổ số']);
      }else{
        $data=$request->all();
        $data['user_id']=Auth::user()->id;
        $validator=Validator::make($data, [
          'result_prediction'=>'numeric|digits:2',
          'money'=>'numeric'
        ]);
        if($validator->fails()){
          return response()->json(['statusCode'=>403, 'message'=>'Số dự đoán từ 00 đến 99']);
        }else if($data['money']>Auth::user()->money){
          return response()->json(['statusCode'=>403, 'message'=>'Không đủ tiền cược']);
        }else{
          if($data['status']==1){
            if(!isset($data['money'])||!isset($data['result_prediction'])){
              return response()->json(['statusCode'=>403, 'message'=>'Bạn chưa đặt điểm hoặc kết quả']);
            }else{
              $data['created_at']=date('Y-m-d', strtotime(Carbon::now()));
              Winner::create($data);
              User::find(Auth::user()->id)->update(['money'=>Auth::user()->money-$data['money']]);
              return response()->json(['statusCode'=>200, 'message'=>'Đặt thành công!']);
            }
          }else if($data['status']==0){
            if(!isset($data['money'])||!isset($data['result_prediction'])){
              return response()->json(['statusCode'=>403, 'message'=>'Bạn chưa đặt điểm hoặc kết quả']);
            }else{
              $data['created_at']=date('Y-m-d', strtotime(Carbon::now()));
              Winner::create($data);
              User::find(Auth::user()->id)->update(['money'=>Auth::user()->money-$data['money']]);
              return response()->json(['statusCode'=>200, 'message'=>'Đặt thành công!']);
            }
          }
        }
      }
    }else{
      return response()->json(['statusCode'=>403, 'message'=>'Bạn cần đăng nhập để đặt số']);
    }
  }
  public function history(){
    $winners=Winner::where('user_id', Auth::user()->id)->orderBy('id', 'desc')->get()->toArray();
    $xxx=array();
    foreach($winners as $winner){
      array_push($xxx, ['type'=>$winner['type'], 'result_prediction'=>$winner['result_prediction'], 'money'=>$winner['money'], 'created_at'=>date('d/m/Y', strtotime($winner['created_at'])), 'status'=>$winner['status']]);
    }
    return response()->json(['statusCode'=>200, 'data'=>['history'=>$xxx]]);
  }
  public function getPrize(Request $request){
    $data=$request->all();
    $winner=Winner::find($data['id']);
    $winner->update(['status'=>-1]);
    if($winner['check']==1){
      User::find(Auth::user()->id)->update(['money'=>Auth::user()->money+$winner['money']*Money::first()->dac_biet]);
      return response()->json(['statusCode'=>200, 'message'=>'Bạn đã nhận thưởng']);
    }else{
      User::find(Auth::user()->id)->update(['money'=>Auth::user()->money]);
      return response()->json(['statusCode'=>200, 'message'=>'Bạn đã nhận thưởng']);
    }
    
  }
}
