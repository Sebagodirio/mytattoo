@extends('layouts.app')

@section('content')

<?php $flag = false ?>
<h1 style="color: white; text-align:center;">Seguidores</h1><hr>
@foreach($followers as $follow)
<div class="container">
    <?php
    $user = $follow->getUser($follow->follower);
    $flag = true;
    ?>

    <div class="follow-box d-flex">
        @if($user->image)
        <div class="avatar-max">
            <img src="{{ route('user.avatar',['filename' => $user->image]) }}">
        </div>
        @endif
        <div class="d-flex flex-column data-follower">
            <div>
                <h2><a href="{{ route('user.detail',['id' => $user->id]) }}">
                    {{'@'.$user->nickname}}
                </a></h2>
            </div>
            <div><span>{{$user->name.' '.$user->surname}}</span></div>
            @if($user->description)
            <div>
                <p>{{$user->description}}</p>
            </div>
            @endif
        </div>
    </div>

</div>

@endforeach
@if(!$flag)
<div class="container">
    <div class="alert alert-danger text-center">
        <p>Nadie te sigue</p>
    </div>
</div>
@endif
@endsection