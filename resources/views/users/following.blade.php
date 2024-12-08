@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>المتابَعون</h1>

        @foreach ($following as $followed)
            <div class="followed mb-3">
                <h5>{{ $followed->name }}</h5>
                <small>انضم منذ {{ $followed->created_at->diffForHumans() }}</small>
            </div>
            <hr>
        @endforeach
    </div>
@endsection
