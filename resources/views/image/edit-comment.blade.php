@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Editar comentario') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('comment.update') }}">
                        @csrf

                        <div>
                            <textarea name="content" class="form-control">{{ $comment->content }}</textarea>
                        </div>
                        <input type="hidden" value="{{ $comment->id }}" name="comment_id">
                        <input type="hidden" value="{{ $comment->image_id }}" name="image_id">
                        <button class="btn btn-success" type="submit">Enviar</button>
    
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
