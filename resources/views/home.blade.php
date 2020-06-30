@extends('layouts.app')

@section('content')
<div class="container">
    <!-- Here i´ll show every image, no matter if auth user is not follower of this people. I do this due to there is no many people in this app. But I could show only the user who are followed by the auth user. An example to do this is in the section "Seguidos" -->
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if(session('message'))
            <div class="alert alert-success">
                {{session('message')}}
            </div>
            @endif

            @foreach($images as $image) <!-- I loop throug evety image in the app -->
            <div class="card" style="margin-bottom: 20px;">
                <div class="card-header">
                    <ul class="d-flex card-image">
                        @if($image->user->image) <!-- The user maybe has an avatar or maybe not -->
                        <li class="avatar-min"><img src="{{ route('user.avatar',['filename' => $image->user->image]) }}">
                        </li>
                        @endif
                        <a href="{{ route('user.detail',['id' => $image->user->id]) }}">
                            <li class="text-muted">{{'@'.$image->user->nickname }}</li>
                            @if($image->user_id == Auth::user()->id) <!-- If the image belongs to the auth user, he/she can delete the image. -->
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
                        <!-- I loop through the likes of the image, if the auth user picked like in this photo, it will be showed a red heart, if not, it will be showed the empty one. The user can pick any heart in order to give 'like' or 'dislike'. This action is controlled by the like´s controller, and by ajax application. This archive is in public/js/main.js-->
                        @foreach($image->likes as $like) 
                        @if($like->user->id == Auth::user()->id)
                        <?php $flag = true; ?> <!-- If the like exists I turn a flag in true -->
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

            <!-- Pagination -->
            {{$images->links()}} 
        </div>
    </div>
</div>
@endsection