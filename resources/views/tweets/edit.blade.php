@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>تعديل التغريدة</h1>

        {{-- <!-- عرض رسائل الخطأ في حالة وجود مشاكل في التحقق من البيانات -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif --}}

        <!-- نموذج تعديل التغريدة -->
        <form action="{{ route('tweets.update', $tweet) }}" method="POST">
            @csrf
            @method('PUT')
            <textarea name="text" class="form-control mb-3" required>{{ old('text', $tweet->text) }}</textarea>
            <button type="submit" class="btn btn-primary">تعديل</button>
        </form>
    </div>
@endsection
