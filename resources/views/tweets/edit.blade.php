@extends('layouts.main')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-header bg-primary text-white p-3">
                    <h4 class="mb-0">
                        <i class="fas fa-edit me-2"></i>
                        تعديل التغريدة
                    </h4>
                </div>
                
                <div class="card-body p-4">
                    @if ($errors->any())
                        <div class="alert alert-danger rounded-3">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('tweets.update', $tweet) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <textarea 
                                name="text" 
                                class="form-control border-0 bg-light rounded-3"
                                style="resize: none;"
                                rows="4"
                                required
                            >{{ old('text', $tweet->text) }}</textarea>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary rounded-pill px-4">
                                <i class="fas fa-check me-2"></i>حفظ التعديلات
                            </button>
                            <a href="{{ route('home') }}" class="btn btn-outline-secondary rounded-pill px-4">
                                <i class="fas fa-times me-2"></i>إلغاء
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    textarea:focus {
        box-shadow: none !important;
        border-color: #1DA1F2 !important;
    }
    
    .btn-primary {
        background-color: #1DA1F2;
        border-color: #1DA1F2;
    }
    
    .btn-primary:hover {
        background-color: #1a91da;
        border-color: #1a91da;
    }
</style>
@endsection
