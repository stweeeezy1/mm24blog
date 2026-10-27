@extends('partials.layout')
@section('content')
    <div class="container mx-auto">
        @include('partials.post-card')
        <h1>Comments:</h1>

        @auth
            <form method="POST" action="{{ route('comments.store', $post) }}" class="card bg-base-300 shadow-sm p-3 mt-2">
                @csrf
                <fieldset class="fieldset">
                    <legend class="fieldset-legend">@lang('Comment')</legend>
                    <textarea name="body" rows="3"
                        class="textarea w-full @error('body') textarea-error @enderror">{{ old('body') }}</textarea>
                    @error('body')
                        <p class="label text-error">{{ $message }}</p>
                    @enderror
                </fieldset>
                <div class="flex justify-end mt-2">
                    <button class="btn btn-primary">@lang('Add comment')</button>
                </div>
            </form>
        @endauth

        @foreach($post->comments as $comment)
            <div class="card bg-base-300 shadow-sm mt-2">
                <div class="card-body">
                    <p>{{ $comment->body }}</p>
                    <span class="text-base-content/70">{{ $comment->user->name }}</span>
                    <span class="text-base-content/70">{{ $comment->created_at->diffForHumans() }}</span>
                    <div class="card-actions justify-end"></div>
                </div>
            </div>
        @endforeach
    </div>
@endsection