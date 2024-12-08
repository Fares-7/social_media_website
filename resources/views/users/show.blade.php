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
                                <strong>{{ $postCount }}</strong>

                                <div>Posts</div>
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
                                <div class="border-bottom p-3">
                                    <p>{{ $tweet->content }}</p>
                                    <small class="text-muted">{{ $tweet->created_at->diffForHumans() }}</small>
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
