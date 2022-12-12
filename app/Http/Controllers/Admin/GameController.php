<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Game;
class GameController extends Controller
{
    public function index(){
        $games=Game::all();
        return View('admin.game.index', compact('games'));
    }
    public function create(Request $request){
        $data=$request->all();
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $reimage = 'imgs/'.time() . '.' . $image->getClientOriginalExtension();
            $dest = public_path('/imgs');
            $image->move($dest, $reimage);
            $data['image']=$reimage;
            Game::create($data);
            return redirect()->back();
        }
    }
    public function edit(Request $request, $id){
        $game=Game::find($id);
        $data=$request->all();
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $reimage = 'imgs/'.time() . '.' . $image->getClientOriginalExtension();
            $dest = public_path('/imgs');
            $image->move($dest, $reimage);
            $data['image']=$reimage;
            $game->update($data);
            return redirect()->back();
        }else{
            $game->update($data);
            return redirect()->back();
        }
    }
    public function delete($id){
        Game::find($id)->delete();
        return redirect()->back();
    }
}
