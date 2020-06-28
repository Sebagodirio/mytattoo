<?php

namespace App\Http\Controllers;

use App\Image;
use Illuminate\Http\Request;
use App\Like;


class LikeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    
    public function like($image_id){ 
        //Recoger datos del usuario y la imagen
        $user = \Auth::user();
         
        
        //Comprobar si existe el like para no duplicarlo

        $isset_like = Like::where('user_id',$user->id)
                            ->where('image_id',(int)$image_id)
                            ->count();

       

        if(!$isset_like){

            $like = new Like();
            $like->user_id = $user->id;
            $like->image_id = (int)$image_id;

            //Guardar en base de datos

            $like->save();

            return response()->json([ //RETORNO UN ARCHIVO JSON PARA TRABAJAR CON AJAX
                'like' => $like
            ]);
        } else{
            return response()->json([
                'message' => 'El like ya existe'
            ]);
        }
    }

    public function dislike($image_id){
        //Recoger datos del usuario y la imagen
        $user = \Auth::user();

        //Comprobar si existe el like para no duplicarlo

        $like = Like::where('user_id',$user->id)->where('image_id',$image_id)->first();

        if($like){

            //Eliminar like
            $like->delete();
            

            return response()->json([ //RETORNO UN ARCHIVO JSON PARA TRABAJAR CON AJAX
                'like' => $like,
                'message' => 'Has dado dislike'
            ]);
        } else{
            return response()->json([
                'message' => 'El like no existe'
            ]);
        }
    }
}
