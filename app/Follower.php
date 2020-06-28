<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use App\User;

class Follower extends Model
{
    public function users(){
        return $this->belongsTo('App\User');
    }

    public function getUser($id){
        $user = User::find($id);

        return $user;
    }
}
