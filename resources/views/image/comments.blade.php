@extends('layouts.app')

@section('content')
<div class="container" style="height:100%;">
    <div class="row justify-content-center">
        <div class="col-md-8" style="height:100vh">
            @if(session('message'))
            <div class="alert alert-success">
                {{session('message')}}
            </div>
            @endif


            <div class="card card-detail">
                <div class="card-header">
                    <ul class="d-flex card-image">
                        @if($image->user->image)
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
                                @if(Auth::user()->id == $like->user->id)
                                    <?php $flag = true ?>
                                @endif
                            @endforeach

                            @if($flag)
                                <img src="{{ asset('img/heart_full.png') }}" data-id="{{ $image->id }}" class="btn-dislike">
                            @else
                                <img src="{{ asset('img/heart_empty.png') }}" data-id="{{ $image->id }}" class="btn-like">
                            @endif
                            <span class="text-muted">| Comentarios({{count($image->comments)}})</span>
                        </div>
                        <div class="comment-box">
                            <form action="{{ route('comment') }}" method="POST">
                                @csrf
                                <textarea name="content" class="form-control" placeholder="Deja tu comentario"></textarea>

                            <input type="hidden" value="{{ $image->id }}" name="image_id">

                                <button type="submit" class="btn btn-success">Enviar</button>
                            </form>
                            <div style="position:relative">
                                @foreach($image->comments as $comment)

                                <div>
                                    <ul class="d-flex card-image">
                                        @if($comment->user->image)
                                        <li class="avatar-min"><img src="{{ route('user.avatar',['filename' => $comment->user->image]) }}">
                                        </li>
                                        @endif
                                        <li class="text-muted">{{'@'.$comment->user->nickname }}</li>
                                    </ul>
                                <div>
                                    <span>{{$comment->content}}</span>
                                    @if(Auth::user() && Auth::user()->id == $comment->user_id || Auth::user()->id == $image->user_id)
                                        <a href="{{ route('comment.edit',['id' => $comment->id]) }}" class="text-muted">Editar</a>
                                        <a href="{{ route('comment.delete',['id' => $comment->id]) }}" class="text-muted" onclick="javascript:alert('Desea borrar este comentario?')">|  Eliminar</a>

                                    @endif
                                </div>
                                </div>

                                @endforeach
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection