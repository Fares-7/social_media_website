@extends('layouts.app')

@section('content')
<div class="container">
    <h1>التغريدات</h1>

    <!-- إنشاء تغريدة جديدة -->
    <form action="{{ route('tweets.store') }}" method="POST">
        @csrf
        <textarea name="text" class="form-control mb-3" placeholder="اكتب تغريدتك..." required></textarea>
        <button type="submit" class="btn btn-primary">نشر</button>
    </form>

    <hr>

    <!-- عرض التغريدات -->
    @foreach($tweets as $tweet)
        <div class="tweet mb-3">
            <h5>{{ $tweet->user->name }}</h5>
            <p>{{ $tweet->text }}</p>
            <small>{{ $tweet->created_at->diffForHumans() }}</small>

            @if($tweet->user_id === auth()->id())
                <a href="{{ route('tweets.edit', $tweet) }}" class="btn btn-sm btn-warning">تعديل</a>
                <form action="{{ route('tweets.destroy', $tweet) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger">حذف</button>
                </form>
            @endif
        </div>
        <hr>
    @endforeach

    {{ $tweets->links() }} <!-- عرض الترقيم -->
</div>
@endsection
