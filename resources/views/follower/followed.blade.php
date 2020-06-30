@extends('layouts.app')

@section('content')

<?php $flag = false ?>
<h1 style="color: white; text-align:center;">Seguidos</h1><hr>
@foreach($followed as $follow) <!-- I receive the relation from the table of followers, it is a column which has an id which has a relation with the user who is followed by the auth user -->
<div class="container">
    <?php
    $user = $follow->getUser($follow->user_id); /* I get the user who is followed by the auth user. I get him/her by the user_id which i have in the table of followers */
    $flag = true; /*If there is at least one user, i turn true a flag. In case of getting 0 users, the flag is false and i´m gonna use it to show that there is no user followed for the auth user*/
    ?>

    <div class="follow-box d-flex"> 
        @if($user->image) <!-- The user maybe has an avatar, or maybe not -->
        <div class="avatar-max">
            <img src="{{ route('user.avatar',['filename' => $user->image]) }}">
        </div>
        @endif
        <div class="d-flex flex-column data-follower">
            <div>
                <h2>
                    <a href="{{ route('user.detail',['id' => $user->id]) }}">
                        {{'@'.$user->nickname}}
                    </a>
                </h2>
            </div>
            <div><span>{{$user->name.' '.$user->surname}}</span></div>
            @if($user->description) <!-- The user maybe has a description, or maybe not -->
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
        <p>No sigues a nadie. Ir a <a href="{{ route('user.people') }}">buscar personas</a> para seguir gente.</p>
    </div>
</div>
@endif
@endsection