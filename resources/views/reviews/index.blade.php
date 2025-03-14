@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-2xl font-bold mb-6">Reviews</h1>

        <div class="space-y-6">
            @foreach($reviews as $review)
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <div class="flex items-center mb-2">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $review->rating)
                                    <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                @else
                                    <svg class="w-5 h-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                @endif
                            @endfor
                        </div>
                        <p class="text-gray-600">{{ $review->comment }}</p>
                    </div>
                    <div class="text-sm text-gray-500">
                        {{ $review->created_at->diffForHumans() }}
                    </div>
                </div>
                <div class="flex items-center"></div>
                    <div class="flex-shrink-0">
                        @if($review->user->profile_photo)
                            <img class="h-10 w-10 rounded-full" src="{{ Storage::url($review->user->profile_photo) }}" alt="">
                        @else
                            <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center"></div>
                                <span class="text-gray-500 font-medium">{{ substr($review->user->name, 0, 1) }}</span>
                            </div>
                        @endif
                    </div>
                    <div class="ml-3"></div>
                        <p class="text-sm font-medium text-gray-900">{{ $review->user->name }}</p>
                        <p class="text-sm text-gray-500">Project: {{ $review->project->title }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="mt-6"></div>
            {{ $reviews->links() }}
        </div>
    </div>
</div>
@endsection
