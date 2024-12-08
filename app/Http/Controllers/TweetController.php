<?php

namespace App\Http\Controllers;

use App\Models\Tweet;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Like;
use App\Models\Comment;
class TweetController extends Controller
{
    public function index()
    {
        $tweets = Tweet::with(['user', 'likes', 'comments.user'])
            ->latest()
            ->paginate(10);
        
        $users = User::where('id', '!=', auth()->id())->get();
    
        return view('home', compact('tweets', 'users'));
    }
    

    public function store(Request $request)
    {
        $request->validate([
            'text' => 'required|max:140',
        ]);
    
        $tweet = new Tweet();
        $tweet->text = $request->text;
        $tweet->user_id = auth()->id();
        $tweet->save();
    
        return redirect()->back()->with('success', 'تم نشر التغريدة بنجاح!');
    }
    


public function edit(Tweet $tweet)
{
    if ($tweet->user_id !== auth()->id()) {
        abort(403); // التأكد من أن المستخدم يملك التغريدة
    }

    return view('tweets.edit', compact('tweet'));
}

public function update(Request $request, Tweet $tweet)
{
    if ($tweet->user_id !== auth()->id()) {
        abort(403);
    }

    $request->validate([
        'text' => 'required|max:140',
    ]);

    $tweet->update($request->only('text'));

    return redirect()->route('home')->with('success', 'تم تعديل التغريدة بنجاح!');
}

public function destroy(Tweet $tweet)
{
    if ($tweet->user_id !== auth()->id()) {
        abort(403);
    }

    $tweet->likes()->delete(); // Delete associated likes
    $tweet->comments()->delete(); // Delete associated comments
    $tweet->delete();

    return redirect()->back()->with('success', 'تم حذف التغريدة بنجاح!');
}


public function like(Request $request, Tweet $tweet)
{
    // Check if already liked
    if ($tweet->likedBy(auth()->user())) {
        return redirect()->back()->with('error', 'لقد قمت بالإعجاب بهذه التغريدة مسبقاً');
    }

    $tweet->likes()->create([
        'user_id' => auth()->id()
    ]);

    return redirect()->back()->with('success', 'تم الإعجاب بالتغريدة!');
}

public function unlike(Request $request, Tweet $tweet)
{
    $tweet->likes()->where('user_id', auth()->id())->delete();
    
    return redirect()->back()->with('success', 'تم إلغاء الإعجاب!');
}



public function comment(Request $request, Tweet $tweet)
{
    $request->validate([
        'content' => 'required|string|max:255',
    ]);

    $comment = new Comment();
    $comment->content = $request->content;
    $comment->user_id = auth()->id();
    $comment->tweet_id = $tweet->id;
    $comment->save();

    return redirect()->back()->with('success', 'تم إضافة التعليق!');
}



}
