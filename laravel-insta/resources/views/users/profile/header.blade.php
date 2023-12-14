<div class="row">
    <div class="col-4">
      @if ($user->avatar)
          <img src="{{$user->avatar}}" alt="{{ $user->name }}" class="d-block mx-auto avatar-lg">
          <!-- remove the img-thumbnail rounded-circle classes -->
      @else
          <i class="fa-solid fa-circle-user text-secondary d-block text-center icon-lg"></i>
      @endif
    </div>
    <div class="col-8">
      <div class="row mb-3">
        <div class="col-auto">
          <h2 class="display-6 mb-0">{{ $user->name }}</h2>
        </div>
        <div class="col-auto p-2">
          @if (Auth::user()->id === $user->id)
              <a href="{{ route('profile.edit') }}" class="btn btn-outline-secondary btn-sm fw-bold">
                Edit Profile
              </a>
          @else
              @if ($user->isFollowed())
                  <form action="{{ route('follow.destroy', $user->id) }}" method="post">
                    @csrf
                    @method('DELETE')

                    <button type="submit" class="btn btn-outline-secondary btn-sm fw-bold">Following</button>
                  </form>
              @else
                  <form action="{{ route('follow.store', $user->id) }}" method="post">
                    @csrf

                    <button type="submit" class="btn btn-primary btn-sm fw-bold">
                      Follow
                    </button>
                  </form>
              @endif
              
          @endif
        </div>
      </div>
      <div class="row mb-3">
        <div class="col-auto">
          <a href="{{ route('profile.show', $user->id) }}" class="text-decoration-none text-dark">
            <strong>{{ $user->posts->count() }}</strong> 
            @if ($user->posts->count() >= 2)
                posts
            @else
                post
            @endif
          </a>
        </div>
        <div class="col-auto">
          <a href="{{ route('profile.followers', $user->id) }}" class="text-decoration-none text-dark">
            <strong>{{ $user->followers->count() }}</strong> 
            @if ($user->followers->count() >= 2)
                followers
            @else
                follower
            @endif
          </a>
        </div>
        <div class="col-auto">
          <a href="{{ route('profile.followings', $user->id) }}" class="text-decoration-none text-dark">
            <strong>{{ $user->following->count() }}</strong> 
            @if ($user->following->count() >= 2)
                followings
            @else
                following
            @endif
          </a>
        </div>
      </div>
      <div class="row mb-3">
        <p class="fw-bold">{{ $user->introduction }}</p>
      </div>
    </div>
</div>