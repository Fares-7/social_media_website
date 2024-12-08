@extends('layouts.main')

@section('content')
    <div class="container">
        <div class="row">
            <!-- User Profile Info -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body text-center">
                        @if ($user->image)
                            <img src="{{ asset('storage/' . $user->image) }}" class="rounded-circle mb-3"
                                style="width: 150px; height: 150px; object-fit: cover;" alt="{{ $user->name }}">
                        @endif
                        <h4>{{ $user->name }}</h4>

                        <div class="d-flex justify-content-around my-3">
                            <div>
                                <strong>{{ $followersCount }}</strong>
                                <div>Followers</div>
                            </div>
                            <div>
                                <strong>{{ $followingCount }}</strong>
                                <div>Following</div>
                            </div>
                            <div>
                                <strong>{{ $tweetCount }}</strong>

                                <div>Tweets</div>
                            </div>
                        </div>

                        @if (auth()->id() !== $user->id)
                            @if (auth()->user()->isFollowing($user))
                                <form action="{{ route('unfollow', $user) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger">Unfollow</button>
                                </form>
                            @else
                                <form action="{{ route('follow', $user) }}" method="POST">
                                    @csrf
                                    <button class="btn btn-primary">Follow</button>
                                </form>
                            @endif
                        @endif
                    </div>
                </div>
            </div>

            <!-- User Tweets -->
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        Tweets
                    </div>
                    <div class="card-body">
                        @if ($tweets->isEmpty())
                            <p class="text-muted">No tweets to show.</p>
                        @else
                            @foreach ($tweets as $tweet)
                                <div class="card mb-3 tweet-card">
                                    <div class="card-body">
                                        <div class="d-flex mb-3">
                                            @if ($tweet->user->image)
                                                <a href="{{ route('users.show', $tweet->user) }}">
                                                    <img src="{{ Storage::url($tweet->user->image) }}" alt="Profile Image"
                                                        class="rounded-circle me-3"
                                                        style="width: 40px; height: 40px; object-fit: cover;">
                                                </a>
                                            @else
                                                <a href="{{ route('users.show', $tweet->user) }}">
                                                    <div class="user-avatar bg-primary me-3"
                                                        style="width: 40px; height: 40px;">
                                                        {{ substr($tweet->user->name, 0, 1) }}
                                                    </div>
                                                </a>
                                            @endif
                                            <div>
                                                <a href="{{ route('users.show', $tweet->user) }}"
                                                    class="text-decoration-none text-dark">
                                                    {{ $tweet->user->name }}
                                                </a>
                                                <small class="text-muted">{{ $tweet->created_at->diffForHumans() }}</small>
                                            </div>
                                        </div>

                                        <p class="card-text">{{ $tweet->text }}</p>

                                        <div class="interaction-buttons d-flex gap-3">
                                            <!-- Like Button -->
                                            <form
                                                action="{{ route($tweet->likedBy(auth()->user()) ? 'tweets.unlike' : 'tweets.like', $tweet) }}"
                                                method="POST">
                                                @csrf
                                                @if ($tweet->likedBy(auth()->user()))
                                                    @method('DELETE')
                                                @endif
                                                <button type="submit"
                                                    class="btn btn-sm {{ $tweet->likedBy(auth()->user()) ? 'btn-primary' : 'btn-outline-primary' }} rounded-pill">
                                                    <i class="fas fa-heart"></i> {{ $tweet->likes->count() }}
                                                </button>
                                            </form>

                                            <!-- Comment Button -->
                                            <button class="btn btn-sm btn-outline-secondary rounded-pill"
                                                data-bs-toggle="collapse" data-bs-target="#comments-{{ $tweet->id }}">
                                                <i class="fas fa-comment"></i> {{ $tweet->comments->count() }}
                                            </button>

                                            @if ($tweet->user_id === auth()->id())
                                                <!-- Edit Button -->
                                                <a href="{{ route('tweets.edit', $tweet) }}"
                                                    class="btn btn-sm btn-outline-warning rounded-pill">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <!-- Delete Button -->
                                                <form action="{{ route('tweets.destroy', $tweet) }}" method="POST"
                                                    class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="btn btn-sm btn-outline-danger rounded-pill">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>

                                        <!-- Comments Section -->
                                        <div class="collapse mt-3" id="comments-{{ $tweet->id }}">
                                            <div class="card card-body bg-light">
                                                @foreach ($tweet->comments as $comment)
                                                    <div class="d-flex mb-2">
                                                        <div class="user-avatar bg-secondary me-2"
                                                            style="width: 30px; height: 30px; font-size: 0.8rem;">
                                                            {{ substr($comment->user->name, 0, 1) }}
                                                        </div>
                                                        <div>
                                                            <strong>{{ $comment->user->name }}</strong>
                                                            <p class="mb-0">{{ $comment->content }}</p>
                                                        </div>
                                                    </div>
                                                @endforeach

                                                <form action="{{ route('tweets.comment', $tweet) }}" method="POST"
                                                    class="mt-3">
                                                    @csrf
                                                    <div class="input-group">
                                                        <textarea name="content" class="form-control" rows="1" placeholder="Write a comment..." required></textarea>
                                                        <button type="submit" class="btn btn-primary">
                                                            <i class="fas fa-paper-plane"></i>
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                            <div class="mt-3">
                                {{ $tweets->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
