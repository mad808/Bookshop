<div class="border rounded bg-white shadow-md p-5">
    <div class="text-end">
        @if($book->created_at >= \Carbon\Carbon::now()->subMonths(3)->toDateTimeString())
            <span class="badge bg-success-subtle border border-success-subtle text-success-emphasis rounded-pill">
                    @lang('app.new')
                </span>
        @endif
            @auth
                @if(auth()->user()->id == $book->user_id)
                <div>
                    <a href="{{ route('books.edit', $book->id) }}" class="btn btn-success btn-sm text-decoration-none">
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
                                    @lang('app.delete-question', ['name' => $book->name])
                                </div>
                                <div class="modal-footer">
                                    <form action="{{ route('books.delete', $book->id) }}" method="post">
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
                    <img id="myImg" src="{{ $book->image() }}" width="550" height="350" alt="" class="img-fluid w-100 border rounded mt-4">
                </div>
            </div>
              <div id="myModal" class="modal">
                  <span class="close">&times;</span>
                  <img class="modal-content" id="img01">
                  <div id="caption"></div>
              </div>
            <div class="col mx-2">

                <div class="d-block fw-bold mt-1 text-dark">@lang('app.awtor') :
                  <i class="text-dark"> {{ $book->name }} </i>
                </div>

                <div class="d-block fw-bold mt-1 text-dark">@lang('app.nesirediji') :
                    <i class="text-dark"> {{ $book->writertwo }} </i>
                </div>

                <a href="{{ route('books.index', ['brand' => $book->brand->id]) }}" class="text-dark text-decoration-none fw-bold">
                    @lang('app.category') :<i class="text-dark" > {{ $book->brand->name }} </i>
                </a>

                <div class="d-block fw-bold">
                    <span class="text-dark bi bi-qr-code"> @lang('app.bar_code') : </span> {{ $book->bar_code }}
                </div>

                <a href="{{ route('books.index', ['location' => $book->booklang->id]) }}" class="fw-bold text-dark text-decoration-none bi bi-translate"> @lang('app.location') :
                    {{ $book->booklang->name }}
                </a>


                <br>
                <a href="{{ route('books.index', ['year' => $book->year->id]) }}" class="mt-1 fw-bold text-dark text-decoration-none bi bi-calendar"> @lang('app.year') :
                    {{ $book->year->name }}
                </a>

                <div class="d-flex justify-content-between align-items-center fw-semibold">
                    <div>@lang('app.pagecount') :
                    <span class="text-dark">
                    {{ round($book->bookspage, 2) }}
                    </span>
                    </div>
                </div>




                <div class="d-flex align-items-center fw-bold mb-2 mt-1">

                    <div class="me-4 mt-1">
                        <i class="bi bi-eye-fill text-dark"></i> {{ $book->viewed }}
                    </div>
                    <a href="{{ route('books.favorite', $book->id) }}" class="btn btn-danger btn-sm text-decoration-none">
                        <i class="bi bi-heart-fill"></i> {{ $book->favorited }}
                    </a>
                </div>
                <div class="d-flex justify-content-between align-items-center mt-2 fw-semibold">
                    <div>
            <span class="text-primary">
                ∙ {{ round($book->price, 2) }}<small>.00 TMT</small>
            </span>
                    </div>

                    <div class="btn-hover border border-danger rounded-5 px-4 py-1">
            <span class=" bi bi-bag"> @lang('app.add')</span>
                    </div>

                    <style>
                        .btn-hover {
                            color: darkred;
                            transition: all 0.5s ease 0s;
                        }

                        .btn-hover:hover {
                           color: white;
                            background-color: darkred;
                            cursor: pointer;
                        }
                    </style>

                </div>
                <div class="text-dark fw-semibold mt-1">
                    <p class="rounded-5 border border-1 border-secondary p-3 mt-2">
                    ∙ {{ $book->description }} ({{ $book->created_at }})
                    </p>

                </div>
            </div>
        </div>
      </div>
