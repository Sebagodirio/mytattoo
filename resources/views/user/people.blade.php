@extends('layouts.app')

@section('content')

         <div class="container">
            <form action="{{ route('user.people') }}" method="GET" id="buscador">
                <div class="row">
                    <div class="form-group col">
                        <input type="text" id="search"  class="form-control" placeholder="buscar...">
                    </div>
                    <div class="form-group col btn-search">
                        <input type="submit" value="Buscar" class="btn btn-success">
                    </div>
                </div>
            </form>
            </div>
@if($users)
@foreach($users as $user)



<div class="container">

    

    <div class="follow-box d-flex">
        @if($user->image)
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
            @if($user->description)
            <div>
                <p>{{$user->description}}</p>
            </div>
            @endif
        </div>
    </div>

</div>

@endforeach
    <div class="container">
        {{$users->links()}}
    </div>
@else
<div class="container">
    <div class="alert alert-danger text-center">
        <span>No se encontro ningun usuario.</span>
    </div>
</div>
@endif

@endsection