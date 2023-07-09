
  @if (session('info'))
    <div class="alert alert-info">
      {{ session('info') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @endif

  @if (session('warning'))
    <div class="alert alert-warning">
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      {{ session('warning') }}
    </div>
  @endif

	@if (session('status'))
	  <div class="alert alert-success">
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
	    {{ session('status') }}
	  </div>
	@endif

  @if (count($errors) > 0)
    <div class="alert alert-danger">
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      <ul>
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif
