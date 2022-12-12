<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Game;
use App\Models\Winner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\User;
use App\Models\Policy;
use App\Models\App;
class HomeController extends Controller
{
    public function pagination($items, $perPage = 8, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }
    public function home(){
        $games=Game::all();
        foreach($games as $game){
            $game['image']="https://huytest.top/".$game['image'];
        }
        $winners=Winner::where('check',1)->orderBy('id', 'desc')->get()->toArray();
        $xxx=array();
        foreach($winners as $winner){
            array_push($xxx, ['name'=>User::find($winner['user_id'])->name,'created_at'=> date('d/m/Y', strtotime($winner['created_at']))]);
        }
        $data=$this->pagination($xxx);
        if(!Auth::check()){
            return response()->json(['statusCode'=>200, 'data'=>['games'=>$games, 'winners'=>$data, 'price'=>0]]);
        }else{
            return response()->json(['statusCode'=>200, 'data'=>['games'=>$games, 'winners'=>$data, 'price'=>Auth::user()->money]]);
        }
    }
    public function policy(){
        return response()->json(['statusCode'=>200, 'data'=>['policy'=>Policy::first()->description]]);
    }
    public function app(){
        return response()->json(['statusCode'=>200, 'data'=>['app'=>App::first()->description]]);
    }
}
