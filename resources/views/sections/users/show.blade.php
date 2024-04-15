@extends('layouts.html')
@section('content')
    @pushOnce('links')
        <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
    @endPushOnce
    <div class="flex px-24 w-full">
        <div class="flex justify-between">
            @if ($user->profile_img == null)
                <svg xmlns="http://www.w3.org/2000/svg" class="profile-svg"
                    viewBox="0 0 448 512"><!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                    <path
                        d="M224 256A128 128 0 1 0 224 0a128 128 0 1 0 0 256zm-45.7 48C79.8 304 0 383.8 0 482.3C0 498.7 13.3 512 29.7 512H418.3c16.4 0 29.7-13.3 29.7-29.7C448 383.8 368.2 304 269.7 304H178.3z" />
                </svg>
            @else
                <img src="{{ asset('storage/user_profile_images/' . $user->profile_img) }}" alt="" class="profile-img">
            @endif
        </div>
    </div>
@endsection
