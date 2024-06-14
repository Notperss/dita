{{-- @if (!$name)
  @error($name)
    <span class="text-danger text-sm">{{ $message }}</span>
  @enderror
@else --}}
@forelse ($errors->all() as $error)
  <div class="alert alert-danger alert-dismissible fade show" role="alert">
    {{ $error }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
@empty
@endforelse
{{-- @endif --}}
