@extends('layouts.main')

@section('content')
<div class="container">
    <div class="row">
        <!-- Left Sidebar -->
<div class="col-md-3">
    <div class="card mb-4">
        <div class="card-body">
            <div class="text-center mb-3">
                @if(auth()->user()->image)
                    <img src="{{ Storage::url(auth()->user()->image) }}" 
                         alt="Profile Image" 
                         class="rounded-circle mb-3"
                         style="width: 100px; height: 100px; object-fit: cover;">
                @else
                    <div class="user-avatar bg-primary mx-auto mb-3"
                         style="width: 100px; height: 100px; font-size: 2.5rem;">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                @endif
                
                <h5 class="card-title">{{ auth()->user()->name }}</h5>
                <p class="text-muted">{{ '@' . auth()->user()->name }}</p>
            </div>

            <div class="d-flex justify-content-between mt-3">
                <div class="text-center">
                    <div class="fw-bold">{{ auth()->user()->tweets->count() }}</div>
                    <small class="text-muted">Tweets</small>
                </div>
                <div class="text-center">
                    <div class="fw-bold">{{ auth()->user()->following->count() }}</div>
                    <small class="text-muted">Following</small>
                </div>
                <div class="text-center">
                    <div class="fw-bold">{{ auth()->user()->followers->count() }}</div>
                    <small class="text-muted">Followers</small>
                </div>
            </div>
        </div>
    </div>
</div>


        <!-- Main Content -->
        <div class="col-md-6">
            <!-- Tweet Creation -->
            <div class="card mb-4 tweet-card">
                <div class="card-body">
                    <form action="{{ route('tweets.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <textarea 
                                name="text" 
                                class="form-control border-0" 
                                rows="3" 
                                placeholder="What's happening?"
                                required
                            ></textarea>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary px-4 rounded-pill">
                                Tweet
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Tweets List -->
            @foreach($tweets as $tweet)
            <div class="card mb-3 tweet-card">
                <div class="card-body">
                    <div class="d-flex mb-3">
                        @if($tweet->user->image)
                        <img src="{{ Storage::url($tweet->user->image) }}" 
                             alt="Profile Image" 
                             class="rounded-circle me-3"
                             style="width: 40px; height: 40px; object-fit: cover;">
                    @else
                        <div class="user-avatar bg-primary me-3" style="width: 40px; height: 40px;">
                            {{ substr($tweet->user->name, 0, 1) }}
                        </div>
                    @endif
                        <div>
                            <h6 class="mb-0">{{ $tweet->user->name }}</h6>
                            <small class="text-muted">{{ $tweet->created_at->diffForHumans() }}</small>
                        </div>
                    </div>

                    <p class="card-text">{{ $tweet->text }}</p>

                    <div class="interaction-buttons d-flex gap-3">
                        <!-- Like Button -->
                        <form action="{{ route($tweet->likedBy(auth()->user()) ? 'tweets.unlike' : 'tweets.like', $tweet) }}" 
                              method="POST">
                            @csrf
                            @if($tweet->likedBy(auth()->user()))
                                @method('DELETE')
                            @endif
                            <button type="submit" class="btn btn-sm {{ $tweet->likedBy(auth()->user()) ? 'btn-primary' : 'btn-outline-primary' }} rounded-pill">
                                <i class="fas fa-heart"></i> {{ $tweet->likes->count() }}
                            </button>
                        </form>

                        <!-- Comment Button -->
                        <button class="btn btn-sm btn-outline-secondary rounded-pill" 
                                data-bs-toggle="collapse" 
                                data-bs-target="#comments-{{ $tweet->id }}">
                            <i class="fas fa-comment"></i> {{ $tweet->comments->count() }}
                        </button>

                        @if($tweet->user_id === auth()->id())
                            <!-- Edit Button -->
                            <a href="{{ route('tweets.edit', $tweet) }}" 
                               class="btn btn-sm btn-outline-warning rounded-pill">
                                <i class="fas fa-edit"></i>
                            </a>
                            <!-- Delete Button -->
                            <form action="{{ route('tweets.destroy', $tweet) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        @endif
                    </div>

                    <!-- Comments Section -->
                    <div class="collapse mt-3" id="comments-{{ $tweet->id }}">
                        <div class="card card-body bg-light">
                            @foreach($tweet->comments as $comment)
                            <div class="d-flex mb-2">
                                <div class="user-avatar bg-secondary me-2" style="width: 30px; height: 30px; font-size: 0.8rem;">
                                    {{ substr($comment->user->name, 0, 1) }}
                                </div>
                                <div>
                                    <strong>{{ $comment->user->name }}</strong>
                                    <p class="mb-0">{{ $comment->content }}</p>
                                </div>
                            </div>
                            @endforeach

                            <form action="{{ route('tweets.comment', $tweet) }}" method="POST" class="mt-3">
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

            <!-- Pagination -->
            <div class="d-flex justify-content-center">
                {{ $tweets->links('pagination::bootstrap-5') }}
            </div>
        </div>

        <!-- Right Sidebar -->
        <div class="col-md-3">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0">Who to Follow</h5>
                </div>
                <div class="card-body p-0">
                    @foreach($users as $user)
                    <div class="d-flex justify-content-between align-items-center p-3 border-bottom">
                        <div class="d-flex align-items-center">
                            <div class="user-avatar bg-secondary me-2">
                                {{ substr($user->name, 0, 1) }}
                            </div>
                            <div>{{ $user->name }}</div>
                        </div>
                        <form action="{{ route(auth()->user()->isFollowing($user) ? 'unfollow' : 'follow', $user->id) }}" method="POST">
                            @csrf
                            @if(auth()->user()->isFollowing($user))
                                @method('DELETE')  <!-- Only add DELETE method when unfollowing -->
                            @endif
                            <button type="submit" class="btn btn-sm {{ auth()->user()->isFollowing($user) ? 'btn-outline-danger' : 'btn-primary' }} rounded-pill">
                                {{ auth()->user()->isFollowing($user) ? 'Unfollow' : 'Follow' }}
                            </button>
                        </form>
                    </div>
                    @endforeach
                </div>                
            </div>
        </div>
    </div>
</div>
@endsection







