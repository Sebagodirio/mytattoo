@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if(session('message'))
            <!-- Sesion flash to show an action made by the user -->
            <div class="alert alert-success">
                {{session('message')}}
            </div>
            @endif


            <div class="card card-detail">
                <div class="card-header">
                    <ul class="d-flex card-image">
                        @if($image->user->image)
                        <!-- The  user maybe has an avatar or maybe not -->
                        <li class="avatar-min"><img src="{{ route('user.avatar',['filename' => $image->user->image]) }}">
                        </li>
                        @endif
                        <li class="text-muted">{{'@'.$image->user->nickname }}</li>
                    </ul>

                </div>

                <div class="card-body-detail">
                    <div class="card-image-body">
                        <img src="{{ route('image.get',['filename' => $image->image_path]) }}">
                    </div>
                    <div class="d-flex flex-column">
                        <div class="below-box">
                            <?php $flag = false ?>
                            @foreach($image->likes as $like)
                            <!-- I loop through the likes of the image -->
                            @if(Auth::user()->id == $like->user->id)
                            <!-- If any of those likes belongs to the auth user, then I turn a flag in true. -->
                            <?php $flag = true ?>
                            @endif
                            @endforeach

                            @if($flag)
                            <!-- If the flag is true, I´ll show a red heart that means that the auth user picked like in this image. -->
                            <img src="{{ asset('img/heart_full.png') }}" data-id="{{ $image->id }}" class="btn-dislike">
                            @else
                            <!-- If not, I´ll show the empty heart. -->
                            <img src="{{ asset('img/heart_empty.png') }}" data-id="{{ $image->id }}"   class="btn-like">
                            @endif
                            <a href="{{ route('image.likes',['id' => $image->id]) }}"><spam class="text-muted">({{count($image->likes)}})</spam></a>
                            <span class="text-muted">| Comentarios({{count($image->comments)}})</span><!-- Count the comments by image. -->
                        </div>
                        <div class="comment-box">
                            <form action="{{ route('comment') }}" method="POST">
                                @csrf
                                <textarea name="content" class="form-control" placeholder="Deja tu comentario"></textarea>

                                <input type="hidden" value="{{ $image->id }}" name="image_id">

                                <button type="submit" class="btn btn-success">Enviar</button>
                            </form>
                            </div>
                            <div class="comments-box">
                                @foreach($image->comments as $comment)
                                <!-- I loop through the comments of the image -->                                
                                    <div class="comments-box-header">
                                        @if($comment->user->image)
                                        <div class="avatar-min">
                                            <img src="{{ route('user.avatar',['filename' => $comment->user->image]) }}">
                                        </div>
                                        @endif
                                        <div class="text-muted comments-box-text">
                                            {{'@'.$comment->user->nickname }}
                                        </div>
                                    </div>
                                    <div>
                                        <span class="comment-content">{{$comment->content}}</span>
                                        @if(Auth::user() && Auth::user()->id == $comment->user_id || Auth::user()->id == $image->user_id)
                                        <!-- If the comment belongs to auth user, he/she can delete or edit the comment -->
                                        <a href="{{ route('comment.edit',['id' => $comment->id]) }}" class="text-muted">Editar</a>
                                        <a href="{{ route('comment.delete',['id' => $comment->id]) }}" class="text-muted" onclick="javascript:alert('Desea borrar este comentario?')">| Eliminar</a>
                                        @endif
                                    </div>                              
                                @endforeach
                            </div>
                        

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection