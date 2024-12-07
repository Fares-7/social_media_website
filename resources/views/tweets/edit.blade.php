@extends('layouts.app')

@section('content')
<div class="container">
    <h1>تعديل التغريدة</h1>
    <form action="{{ route('tweets.update', $tweet) }}" method="POST">
        @csrf
        @method('PUT')
        <textarea name="text" class="form-control mb-3" required>{{ $tweet->text }}</textarea>
        <button type="submit" class="btn btn-primary">تعديل</button>
    </form>
</div>
@endsection
