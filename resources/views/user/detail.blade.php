@extends('layouts.app')

@section('content')
<div class="container">
            @if(session('message'))
            <div class="alert alert-success">
                {{session('message')}}
            </div>
            @endif
    <div class="d-flex user-detail">
    
        <div>
            @if($user->image)
            <div class="avatar-max ">
                <img src="{{ route('user.avatar',['filename' => $user->image]) }}">
            </div>
            @endif
        </div>
        <div class="d-flex flex-column user-detail-data">
            <div><h2>{{'@'.$user->nickname}}</h2></div>
            <div><span>{{$user->name.' '.$user->surname}}</span></div>
            @if($user->description)
            <div><p>{{$user->description}}</p></div>
            @endif
            <?php $check = false ?>
            @foreach($user->followers as $follow) 
                @if($follow->follower == Auth::user()->id)
                    
                    <?php $check = true ?>
                    
                @endif
            @endforeach
            @if(!(Auth::user()->id == $user->id))    
                @if($check)
                <div><a href="{{ route('follower.unfollow',['id' => $user->id]) }}" class="btn btn-danger">Dejar de seguir</a></div>
                @else
                <div><a href="{{ route('follower.follow',['id' => $user->id]) }}" class="btn btn-primary">Seguir</a></div>
                @endif
            @endif
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-8">
           
        

            @foreach($user->images as $image)
            <div class="card" style="margin-bottom: 20px;">
                <div class="card-header">
                    <ul class="d-flex card-image">
                        @if($user->image)
                        <li class="avatar-min"><img src="{{ route('user.avatar',['filename' => $user->image]) }}">
                        </li>
                        @endif
                        <a href="{{ route('user.detail',['id' => $user->id]) }}">
                            <li class="text-muted">{{'@'.$user->nickname }}</li>
                            @if($image->user_id == Auth::user()->id)
                          <a href="{{ route('image.delete',['id' => $image->id]) }}" onclick="javascript:alert('Desea eliminar la foto?')"><li class="text-muted">Eliminar foto</li></a>
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
            
        </div>
        
    </div>
</div>
@endsection