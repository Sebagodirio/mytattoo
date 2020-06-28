@extends('layouts.app')

@section('content')

@if(count($likes)>0)
<h1 style="color: white; text-align:center;">Likes de la imagen</h1><hr>
@foreach($likes as $like)

    <div class="container">
    <div class="follow-box d-flex">
        @if($like->user->image)
        <div class="avatar-max">
            <img src="{{ route('user.avatar',['filename' => $like->user->image]) }}">
        </div>
        @endif
        <div class="d-flex flex-column data-follower">
            <div>
                <h2>
                    <a href="{{ route('user.detail',['id' => $like->user->id]) }}">
                        {{'@'.$like->user->nickname}}
                    </a>
                </h2>
            </div>
            <div><span>{{$like->user->name.' '.$like->user->surname}}</span></div>
            @if($like->user->description)
            <div>
                <p>{{$like->user->description}}</p>
            </div>
            @endif
        </div>
    </div>

</div>

@endforeach
@else
<div class="container">
    <div class="alert alert-danger">
        <spam>Esta imagen no tiene likes</spam>
    </div>
</div>
@endif
@endsection