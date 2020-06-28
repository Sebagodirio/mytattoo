@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if(session('message'))
            <div class="alert alert-success">
                {{session('message')}}
            </div>
            @endif

            @foreach($images as $image)
            <div class="card" style="margin-bottom: 20px;">
                <div class="card-header">
                    <ul class="d-flex card-image">
                        @if($image->user->image)
                        <li class="avatar-min"><img src="{{ route('user.avatar',['filename' => $image->user->image]) }}">
                        </li>
                        @endif
                        <a href="{{ route('user.detail',['id' => $image->user->id]) }}">
                            <li class="text-muted">{{'@'.$image->user->nickname }}</li>
                            @if($image->user_id == Auth::user()->id)
                          <a href="{{ route('image.delete',['id' => $image->id]) }}"><li class="text-muted">Eliminar foto</li></a>
                            @endif
                         </a>
                    </ul>

                </div>

                <div class="card-body">
                    <div class="card-image-body">
                        <img src="{{ route('image.get',['filename' => $image->image_path]) }}">
                    </div>
                    <div class="below-box">
                        <?php $flag = false; ?>
                        @foreach($image->likes as $like)
                        @if($like->user->id == Auth::user()->id)
                        <?php $flag = true; ?>
                        <!-- RECORRO TODOS LOS LIKES Y SI SE LEVANTA LA BANDERA ES PORQUE EL USUARIO IDENTIFICADO TIENE UN LIKE EN ESA FOTO -->
                        @endif
                        @endforeach

                        @if($flag)
                        <img src="{{ asset('img/heart_full.png') }}" data-id="{{ $image->id }}" class="btn-dislike">
                        @else
                        <img src="{{ asset('img/heart_empty.png') }}" data-id="{{ $image->id }}" class="btn-like">
                        @endif
                       <a href="{{ route('image.likes',['id' => $image->id]) }}"><spam class="text-muted">({{count($image->likes)}})</spam></a>
                        <a href="{{ route('image.comment',['id' => $image->id]) }}"><span class="text-muted">| Comentarios({{count($image->comments)}})</span></a>
                    </div>
                </div>
            </div>

            @endforeach
            {{$images->links()}}
        </div>
    </div>
</div>
@endsection