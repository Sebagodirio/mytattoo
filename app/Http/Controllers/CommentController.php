<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;

class CommentController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function save(Request $request){
        $user = \Auth::user();

        $validate = $this->validate($request,[
            'content' => 'required|string',
            'image_id' => 'required|int'
        ]);

        $content = $request->input('content');
        $image_id = (int)$request->input('image_id');

        $comment = new Comment();

        $comment->user_id = $user->id;
        $comment->image_id = $image_id;
        $comment->content = $content;

        

        $comment->save();

        return redirect()->route('image.comment',['id' => $image_id])->with([
            'message' => 'Comentario publicado correctamente'
        ]);
    }
    public function edit($id){
        $comment = Comment::find($id);

        return view('image.edit-comment',[
            'comment' => $comment
        ]);
    }

    public function update(Request $request){
        $validate = $this->validate($request,[
            'content' => 'required|string|max:255',
            'comment_id' => 'required|int',
            'image_id' => 'required|int'
        ]);
        
        $user = \Auth::user();

        $content = $request->input('content');
        $comment_id = $request->input('comment_id');
        $image_id = $request->input('image_id');

        $comment = Comment::find($comment_id);

        $comment->user_id = $user->id;
        $comment->image_id = $image_id;
        $comment->content = $content;

        $comment->update();

        return redirect()->route('image.comment',[
            'id' => $image_id
        ])->with([
            'message' => 'Comentario modificado correctamente'
        ]);

    }

    public function delete($id){
        $comment = Comment::find($id);
        $image_id = $comment->image_id;
        $comment->delete();

        return redirect()->route('image.comment',[
            'id' => $image_id
        ])->with([
            'message' => 'Comentario eliminado correctamente'
        ]);
    }
}
