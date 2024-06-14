<div class="border rounded shadow-sm bg-white p-3">
    <a href="{{ route('kitaps.show', $kitap->id) }}" class="d-flex justify-content-between">
        <div>
            <div class="mb-1">
                        <img class="img-fluid w-100 rounded" src="{{$kitap->image()}}" style="height: 150px; width: 350px" >

                <div class="d-flex align-items-center justify-content-between">

                    <a href="{{ route('kitaps.index', ['brand' => $kitap->brand->id]) }}" class="text-dark fw-semibold text-decoration-none">
                        {{ $kitap->brand->name }}
                    </a>
                    <div>
                    @if($kitap->created_at >= \Carbon\Carbon::now()->subMonths(3)->toDateTimeString())
                        <span class="badge bg-danger-subtle border border-danger-subtle text-danger-emphasis rounded-pill">
                    @lang('app.new')
                </span>
                    @endif
                    <button class="btn btn-sm" type="button" data-bs-toggle="collapse" data-bs-target="#collapseCar{{ $kitap->id }}" aria-expanded="false" aria-controls="collapseCar{{ $kitap->id }}">
                        <i class="bi-caret-down-fill"></i>
                    </button>
                    </div>
                </div>
            </div>
        </div>
    </a>
    <div id="collapseCar{{ $kitap->id }}" class="small text-secondary collapse">
        <a href="{{ route('kitaps.index', ['booklang' => $kitap->booklang->id]) }}" class="link-dark text-decoration-none">
            {{ $kitap->booklang->name }}
        </a>
        ∙ {{ $kitap->description }} ({{ $kitap->created_at }})
    </div>
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <span class="text-primary fw-semibold">
                {{ round($kitap->price, 2) }} <small>TMT</small>
            </span>
        </div>
        <div>
            <a href="{{ route('kitaps.show', $kitap->id) }}" class="text-dark text-decoration-none">
                <i class="bi-eye-fill"></i> {{ $kitap->viewed }}
            </a>
        </div>
    </div>
</div>