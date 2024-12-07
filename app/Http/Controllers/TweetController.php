<?php

namespace App\Http\Controllers;

use App\Models\Tweet;
use Illuminate\Http\Request;

class TweetController extends Controller
{
    public function index()
{
    $tweets = Tweet::with(['user', 'likes', 'comments.user']) // جلب المستخدم، الإعجابات، والتعليقات مع المستخدمين
        ->latest()
        ->paginate(10); // عرض 10 تغريدات لكل صفحة

    return view('tweets.index', compact('tweets')); // إرسال البيانات إلى واجهة Blade
}


public function store(Request $request)
{
    $request->validate([
        'text' => 'required|max:140', // التحقق من النص
    ]);

    auth()->user()->tweets()->create($request->only('text')); // إنشاء التغريدة للمستخدم الحالي

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
    $request->validate([
        'text' => 'required|max:140',
    ]);

    $tweet->update($request->only('text'));

    return redirect()->route('tweets.index')->with('success', 'تم تعديل التغريدة بنجاح!');
}

public function destroy(Tweet $tweet)
{
    if ($tweet->user_id !== auth()->id()) {
        abort(403); // منع حذف التغريدات الخاصة بآخرين
    }

    $tweet->delete();

    return redirect()->back()->with('success', 'تم حذف التغريدة بنجاح!');
}

public function like(Request $request, Tweet $tweet)
{
    $tweet->likes()->firstOrCreate(['user_id' => auth()->id()]);

    return redirect()->back()->with('success', 'تم الإعجاب بالتغريدة!');
}


public function comment(Request $request, Tweet $tweet)
{
    $request->validate([
        'content' => 'required|string|max:255',
    ]);

    $tweet->comments()->create([
        'user_id' => auth()->id(),
        'content' => $request->content,
    ]);

    return redirect()->back()->with('success', 'تم إضافة التعليق!');
}


}
