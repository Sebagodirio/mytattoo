<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Image;
use App\Like;
use App\Comment;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Response;

class ImageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function formUpload(){
        return view('image.formUpload');
    }

    public function upload(Request $request){
        $validate = $this->validate($request,[
            'content' => 'required|string'
        ]);

        $image = new Image();
        $image->user_id = $request->input('id');
        $image->description = $request->input('content');

        $image_path = $request->file('image');
        
        
        if($image_path){
            $image_name = time().$image_path->getClientOriginalName();

            
            Storage::disk('images')->put($image_name,File::get($image_path));

            $image->image_path = $image_name;
        }

        $image->save();

        return redirect()->route('home')->with(['message' => 'Imagen subida correctamente']);
    }

    public function getImage($filename){
        
        $file = Storage::disk('images')->get($filename);

        return new Response($file,200);
    }

    public function comments($id){

        $image = Image::find($id);

        return view('image.comments',['image' => $image]);
    }

    public function delete($id){

        /* For deleting an image, first I must delete the likes and comments witch belong to the current image */
        $user = \Auth::user();
        $image = Image::find($id);
        $comments = Comment::where('image_id',$id)->get();
        $likes = Like::where('image_id',$id)->get();

        if($user && $image && $image->user_id == $user->id){ /* This image can be deleted ONLY by his owner. */
            /* Eliminar comentarios */

            /* Delete the comments */
            if($comments && count($comments) >= 1){
                foreach($comments as $comment){
                    $comment->delete();
                }
             }
            /* Delete the likes */
            if($likes && count($likes) >= 1){
                foreach($likes as $like){
                    $like->delete();

                    
                }
             }

             /* Delete the image */
            
             /* Delete the image from disk */
             Storage::disk('images')->delete($image->image_path);
            /* Delete image from database */
            $image->delete();

            $message = ['message' => 'La imagen se ha borrado correctamente'];
        }else{
            $message = ['message' => 'La imagen no se ha borrado'];
        }

        return redirect()->route('home')->with($message);

    }

    public function showLikes($id){
        $image = Image::find($id);

        $likes = $image->likes;
         
        return view('likes.show',[
            'likes' => $likes
        ]);
        
    }
}
