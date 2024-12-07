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
        @foreach ($tweets as $tweet)
            <div class="tweet mb-3">
                <h5>{{ $tweet->user->name }}</h5>
                <p>{{ $tweet->text }}</p>
                <small>{{ $tweet->created_at->diffForHumans() }}</small>

                <!-- خيارات التعديل والحذف -->
                @if ($tweet->user_id === auth()->id())
                    <a href="{{ route('tweets.edit', $tweet) }}" class="btn btn-sm btn-warning">تعديل</a>
                    <form action="{{ route('tweets.destroy', $tweet) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">حذف</button>
                    </form>
                @endif

                <!-- الإعجابات -->
                <div class="likes mt-2">
                    <form action="{{ route('tweets.like', $tweet) }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-outline-primary">
                            👍 إعجاب ({{ $tweet->likes->count() }})
                        </button>
                    </form>
                </div>

                <!-- التعليقات -->
                <div class="comments mt-3">
                    <h6>التعليقات:</h6>
                    @foreach ($tweet->comments as $comment)
                        <p>
                            <strong>{{ $comment->user->name }}:</strong> {{ $comment->content }}
                        </p>
                    @endforeach

                    <!-- إضافة تعليق جديد -->
                    <form action="{{ route('tweets.comment', $tweet) }}" method="POST">
                        @csrf
                        <textarea name="content" class="form-control mb-2" placeholder="اكتب تعليقك..." required></textarea>
                        <button type="submit" class="btn btn-sm btn-success">تعليق</button>
                    </form>
                </div>
            </div>
            <hr>
        @endforeach

        {{ $tweets->links() }} <!-- عرض الترقيم -->
    </div>
@endsection
