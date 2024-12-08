@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>المتابعون</h1>

        @foreach ($followers as $follower)
            <div class="follower mb-3">
                <h5>{{ $follower->name }}</h5>
                <small>انضم منذ {{ $follower->created_at->diffForHumans() }}</small>
            </div>
            <hr>
        @endforeach
    </div>
@endsection
