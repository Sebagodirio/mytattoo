@extends('layouts.app')

@section('content')

@if(count($likes)>0)
<!-- This view shows the users who gave like to an image. If the foto has any like: -->
<h1 style="color: white; text-align:center;">Likes de la imagen</h1><hr>
@foreach($likes as $like) <!-- Loop through the likes -->

    <div class="container">
    <div class="follow-box d-flex">
        @if($like->user->image) <!-- The user maybe has an avatar or maybe not. -->
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
            @if($like->user->description) <!-- The user matbe has a description or maybe not. -->
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