{{--Clickable Image--}}
<div class="container p-0">
  <a href="{{ route('post.show', $post->id) }}">
    <img src="{{ $post->image }}" alt="post id {{ $post->id }}" class="w-100">
  </a>
</div>

<div class="card-body">
  {{--Heart button + No. of likes + Categories--}}
  <div class="row align-items-center">
    <div class="col-auto">
      @if ($post->isLiked())
          <form action="{{ route('like.destroy', $post->id)}}" method="post">
          @csrf
          @method('DELETE')
          <button type="submit" class="btn btn-sm shadow-none p-0">
            <i class="fa-solid text-danger fa-heart"></i>
          </button>
          </form>
      @else
        <form action="{{ route('like.store', $post->id) }}" method="post">
          @csrf
          <button type="submit" class="btn btn-sm shadow-none p-0">
            <i class="fa-regular fa-heart"></i>
          </button>
        </form>
      @endif
    </div>
    <div class="col-auto px-0">
      <span>{{ $post->likes->count() }}</span>
      {{-- To show the number of likes oer post --}}
    </div>
    <div class="col text-end">
      @forelse ($post->categoryPost as $category_post)
          {{--categoryPost() was used to retreive the categories under a post--}}
          <div class="badge bg-secondary bg-opacity-50">
            {{ $category_post->category->name }}
          </div>
      @empty
          <div class="badge bg-dark">
            Uncategorized
          </div>
      @endforelse
    </div>
  </div>
  {{--owner of the post (user) + description--}}
  <a href="{{ route('profile.show', $post->user->id) }}" class="text-decoration-none text-dark fw-bold">
    {{ $post->user->name }}
  </a>
  &nbsp; {{--space--}}
  <p class="d-inline fw-light">{{ $post->description }}</p>
  <p class="text-uppercase text-muted xsmall">
    {{ date('M d, Y' , strtotime($post->created_at)) }}
  </p>
  {{--Include comments here--}}
  @include('users.posts.contents.comments')
</div>