<div class="border rounded shadow-sm bg-white p-3">
    <a href="{{ route('books.show', $book->id) }}" class="d-flex justify-content-between">
        <div>
            <div class="mb-1">
                        <img class="img-fluid w-100 rounded" src="{{$book->image()}}" style="height: 150px; width: 350px" >

                <div class="d-flex align-items-center justify-content-between">

                    <a href="{{ route('books.index', ['brand' => $book->brand->id]) }}" class="text-dark fw-semibold text-decoration-none">
                        {{ $book->brand->name }}
                    </a>
                    <div>
                    @if($book->created_at >= \Carbon\Carbon::now()->subMonths(3)->toDateTimeString())
                        <span class="badge bg-success-subtle border border-success-subtle text-success-emphasis rounded-pill">
                    @lang('app.new')
                </span>
                    @endif
                    <button class="btn btn-sm" type="button" data-bs-toggle="collapse" data-bs-target="#collapseCar{{ $book->id }}" aria-expanded="false" aria-controls="collapseCar{{ $book->id }}">
                        <i class="bi-caret-down-fill"></i>
                    </button>
                    </div>
                </div>
            </div>
        </div>
    </a>
    <div id="collapseCar{{ $book->id }}" class="small text-secondary collapse">
        <a href="{{ route('books.index', ['booklang' => $book->booklang->id]) }}" class="link-dark text-decoration-none">
            {{ $book->booklang->name }}
        </a>
        ∙ {{ $book->description }} ({{ $book->created_at }})
    </div>
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <span class="text-primary fw-semibold">
                {{ round($book->price, 2) }} <small>TMT</small>
            </span>
        </div>
        <div>
            <a href="{{ route('books.show', $book->id) }}" class="text-dark text-decoration-none">
                <i class="bi-eye-fill"></i> {{ $book->viewed }}
            </a>
        </div>
    </div>
</div>