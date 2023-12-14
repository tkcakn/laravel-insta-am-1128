@extends('layouts.app')

@section('title', 'Home')

@section('content')

    <div class="row">
        <div class="col-8">
            <div class="p-3">
                @forelse ($home_posts as $post)
                    <div class="card mb-4">
                        {{--TITLE--}}
                        @include('users.posts.contents.title')
                        {{--BODY--}}
                        @include('users.posts.contents.body')
                    </div>
                @empty
                {{--IF THE SITE DOES'T HAVE ANY POST YET--}}
                <div class="text center">
                    <h2>Share Photos</h2>
                    <p class="text-muted">When you share photo, they'll appear on your profile.</p>
                    <a href="{{ route('post.create') }}" class="text-decoration-none">
                    Share you a first photo.</a>
                </div>                  
                @endforelse
            </div>
        </div>
        <div class="col-4">
            <div class="p-3">
                <div class="row align-items-center mb-5 bg-white shadow-sm rounded-3 py-3">
                    <div class="col-auto">
                        <a href="{{ route('profile.show', Auth::user()->id )}}">
                            @if (Auth::user()->avatar)
                                <img src="{{ Auth::user()->avatar }}" alt="{{ Auth::user()->name }}" class="rounded-circle avatar-md">
                            @else
                            <i class="fa-solid-fa-circle-user text-secondary icon-md"></i>
                            @endif
                        </a>
                    </div>    
                    <div class="col ps-0">
                        <a href="{{ route('profile.show', Auth::user()->id )}}" class="text-decoration-none text-dark fw-bold">
                            {{ Auth::user()->name }}
                        </a>
                        <p class="text-muted mb-0">{{ Auth::user()->email }}</p>   
                    </div> 
                </div>
                {{--Suggestions--}}
                @if ($suggested_users)
                    <div class="row">
                        <div class="col-auto">
                            <p class="fw-bold text-secondary">Suggestions For You</p>
                        </div>
                        <div class="col text-end">
                            <a href="#" class="fw-bold text-dark text-decoration-none">See All</a>
                        </div>
                    </div>
                    @foreach ($suggested_users as $user)
                        <div class="row align-items-center mb-3">
                            <div class="col-auto">
                                <a href="{{ route('profile.show', $user->id) }}">
                                    @if ($user->avatar)
                                        <img src="{{ $user->avatar }}" alt="{{ $user->name }}" class="rounded-circle avatar-sm">
                                    @else
                                        <i class="fa-solid fa-circle-user text-secondary icon-sm"></i>
                                    @endif
                                
                                </a>
                            </div>
                            <div class="col ps-0 text-truncate">
                                <a href="{{ route('profile.show', $user->id)}}" class="text-decoration-none text-dark fw-bold">{{ $user->name }}</a>
                            </div>
                            <div class="col-auto">
                                <form action="{{ route('follow.store', $user->id) }}" method="post">
                                    @csrf
                                    <button type="submit" class="border-0 bg-transparent p-0 text-primary btn-sm">Follow</button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
    

@endsection
