<?php

namespace App\Http\Controllers;

use App\Models\Tweet;
use Illuminate\Http\Request;

class TweetController extends Controller
{
    public function index()
{
    $tweets = Tweet::with('user')->latest()->paginate(10); // جلب التغريدات مع المستخدمين المرتبطين بها
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


}
