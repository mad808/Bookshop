<div class="border rounded bg-white shadow-md p-5">
    <div class="text-end">
        @if($kitap->created_at >= \Carbon\Carbon::now()->subMonths(3)->toDateTimeString())
            <span class="badge bg-danger-subtle border border-danger-subtle text-danger-emphasis rounded-pill">
                    @lang('app.new')
                </span>
        @endif
            @auth
                @if(auth()->user()->id == $kitap->user_id)
                <div>
                    <a href="{{ route('kitaps.edit', $kitap->id) }}" class="btn btn-success btn-sm text-decoration-none">
                        <i class="bi bi-pencil-fill"></i> @lang('app.edit')
                    </a>
                    <button type="button" class="btn btn-secondary btn-sm text-decoration-none" data-bs-toggle="modal" data-bs-target="#deleteModal">
                        <i class="bi bi-trash-fill"></i> @lang('app.delete')
                    </button>
                    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="deleteModalLabel">Delete product</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    @lang('app.delete-question', ['name' => $kitap->name])
                                </div>
                                <div class="modal-footer">
                                    <form action="{{ route('cars.delete', $kitap->id) }}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">@lang('app.cancel')</button>
                                        <button type="submit" class="btn btn-secondary">@lang('app.delete')</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                    @endif
            @endauth
    </div>
          <div class="row g-3">
            <div class="col-sm-6 col-lg-4">
                <div class="position-relative d-flex justify-content-center align-items-center">
                    <img src="{{ $kitap->image() }}" width="550" height="350" alt="" class="img-fluid w-100 border rounded mt-4">
                </div>
            </div>
            <div class="col mx-2">
                <a href="{{ route('kitaps.index', ['brand' => $kitap->brand->id]) }}" class="text-dark text-decoration-none h3 fw-bold">
                    {{ $kitap->brand->name }}
                </a>
                <div class="d-block h4 fw-bold mb-2 mt-1">
                    {{ $kitap->name }}
                </div>
                <a href="{{ route('kitaps.index', ['location' => $kitap->booklang->id]) }}" class="fw-bold text-dark text-decoration-none">@lang('app.location') :
                    {{ $kitap->booklang->name }}
                </a>
                <br>

                <div class="d-block fw-bold">
                    <span class="text-dark bi bi-qr-code"> @lang('app.bar_code') : </span> {{ $kitap->bar_code }}
                </div>

                <div class="d-flex align-items-center fw-bold mb-2 mt-1">

                    <div class="me-4 mt-1">
                        <i class="bi bi-eye-fill text-dark"></i> {{ $kitap->viewed }}
                    </div>
                    <a href="{{ route('kitaps.favorite', $kitap->id) }}" class="btn btn-danger btn-sm text-decoration-none">
                        <i class="bi bi-heart-fill"></i> {{ $kitap->favorited }}
                    </a>
                </div>
                <div class="text-dark fw-semibold">
                    <p class="rounded-5 border border-1 border-secondary p-3 mt-2">
                    ∙ {{ $kitap->description }} ({{ $kitap->created_at }})
                    </p>

                </div>
                <div class="d-flex justify-content-between align-items-center mt-2 fw-semibold">
                    <div>
            <span class="text-primary">
                ∙ {{ round($kitap->price, 2) }} <small>TMT</small>
            </span>
                    </div>

                </div>
            </div>
        </div>
      </div>
