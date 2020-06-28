<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Follower;
use App\User;

class FollowerController extends Controller
{
    public function save($id){
        $user = \Auth::user();
        
        $follower = new Follower();
        $follower->user_id = $id;
        $follower->follower = $user->id;

        $follower->save();

        return redirect()->route('user.detail',['id' => $id])->with([
            'message' => 'Usuario seguido correctamente'
        ]);
    }

    public function delete($id){
        $follower = Follower::where('user_id','=',$id)->first();

        
        $follower->delete();

        return redirect()->route('user.detail',['id' => $id])->with([
            'message' => 'Has dejado de seguir a este usuario'
        ]);


    }

    public function getAll(){


        $user = \Auth::user();
        $followed = Follower::where('follower','=',$user->id)->get();

        return view('follower.followed',[
            'followed' => $followed
        ]);
    }
    
    public function getMyFollowers(){
        $user = \Auth::user();

        $followers = Follower::where('user_id','=',$user->id)->get();

        return view('follower.followers',[
            'followers' => $followers
        ]);
    }
}
