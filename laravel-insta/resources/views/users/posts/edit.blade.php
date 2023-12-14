@extends('layouts.app')

@section('title', 'Edit Post')

@section('content')
<form action="{{ route('post.update', $post->id) }}" method="post" enctype="multipart/form-data">
  @csrf
  @method('PATCH')

  <div class="mb-3">
    <label for="category" class="form-lable d-block fw-bold">
      Category <span class="text-muted fa-normal">(up tp 3)</span>
    </label>
    @foreach ($all_categories as $category)
        <div class="form-check form-check-inline">
          {{--"in_array", used to check if a particular value exists in an array--}}
          @if (in_array($category->id, $selected_categories))
              <input type="checkbox" name="category[]" id="{{ $category->name }}" class="form-check-input" value="{{ $category->id }}" checked>
          @else
              <input type="checkbox" name="category[]" id="{{ $category->name }}" class="form-check-input" value="{{ $category->id }}">
          @endif

          <label for="#" class="form-check-label">
            {{ $category->name }}
          </label>
        </div>
    @endforeach
    {{--ERROR--}}
    @error('category')    
        <div class="text-danger small">{{ $message }}</div>
    @enderror
  </div>
  <div class="mb-3">
    <label for="description" class="form-label fw-bold">Description</label>
    <textarea name="description" id="description" rows="3" class="form-control" placeholder="What's on your mind">{{ old('description', $post->description) }}</textarea>
    @error('description')    
        <div class="text-danger small">{{ $message }}</div>
    @enderror
  </div>

  <div class="row mb-4">
    <div class="col-6">
      <label for="image" class="form-label fw-bold">Image</label>

      <img src="{{ $post->image }}" alt="post id{{ $post->id }}" class="img-thumbnail w-100">
      
      <input type="file" name="image" id="image" class="form-control mt-1" aria-describedby="image-info">

      <div class="form-text" id="image-info">
        The acceptable formats are jpeg, jpg, png and gif only.<br>
        Max file is 1048kb.
      </div>
      @error('image')    
        <div class="text-danger small">{{ $message }}</div>
    @enderror
    </div>
  </div>
  <button type="submit" class="btn btn-warning px-5">Save</button>
</form>

@endsection