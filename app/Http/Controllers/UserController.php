<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Contracts\Cache\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; //Para poder usar el storage
use Illuminate\Support\Facades\File;
use App\User;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function config(){

        return view('user.config');
    }

    public function update(Request $request){
        
        $user = \Auth::user();
        $id = $user->id;

        $validate = $this->validate($request,[
        'name' => 'required|string|max:255',
        'surname' => 'required|string|max:255',
        'nickname' => 'required|string|max:255|unique:users,nickname,'.$id, 
        'email' => 'required|string|max:255|unique:users,email,'.$id,
        'description' => 'required|string|max:255',
        'image' => 'image'
        
        ]);

        $user->name = $request->input('name');
        $user->surname = $request->input('surname');
        $user->nickname = $request->input('nickname');
        $user->description = $request->input('description');
        $user->email = $request->input('email');

        //ALMACENAR FOTO EN STORAGE 

        $image = $request->file('image');

        if($image){
            $image_name = time().$image->getClientOriginalName();
            //Guardar en disco
            Storage::disk('users')->put($image_name,File::get($image));

            $user->image = $image_name;
        }

        $user->update();

        return redirect()->route('config')->with([ 
            'message' => 'Configuracion guardada correctamente'           
        ]);

    }

    public function getImage($filename){
        $file = Storage::disk('users')->get($filename);
        return new Response($file,200); 
    }

    public function getUser($id){
        $user = User::find($id);

        return view('user.detail',[
            'user' => $user
        ]);
    }
    public function people($word = null){

        if($word){
            $users = User::query() ->where('name', 'LIKE', "%{$word}%") 
            ->orWhere('surname', 'LIKE', "%{$word}%") 
            ->orWhere('nickname', 'LIKE', "%{$word}%") 
            ->paginate(5);

            

            if(count($users) == 0){
                $users = null;
            }
        } else{

        $users = User::paginate(5);

        }
        return view('user.people',[
            'users' => $users
        ]);
    }
}
