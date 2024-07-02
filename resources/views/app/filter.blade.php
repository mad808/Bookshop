<form action="{{ url()->current() }}">
    <div class="mb-3">
        <label for="brands" class="form-label fw-semibold">@lang('app.brands')</label>
        <select class="form-select form-select-sm" name="brands[]" id="brands" size="3" multiple>
            @foreach($brands as $brand)
                <option value="{{ $brand->id }}" {{ in_array($brand->id, $f_brands) ? 'selected' : '' }}>{{ $brand->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label for="locations" class="form-label fw-semibold">@lang('app.locations')</label>
        <select class="form-select form-select-sm" name="locations[]" id="locations" size="3" multiple>
            @foreach($booklangs as $booklang)
                <option value="{{ $booklang->id }}" {{ in_array($booklang->id, $f_booklangs) ? 'selected' : '' }}>{{ $booklang->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label for="perPage" class="form-label fw-semibold">@lang('app.perPage')</label>
        <select class="form-select form-select-sm" name="perPage" id="perPage">
            @foreach([15, 30, 60, 120] as $perPage)
                <option value="{{ $perPage }}" {{ $perPage == $f_perPage ? 'selected' : '' }}>{{ $perPage }}</option>
            @endforeach
        </select>
    </div>
    {{--@auth--}}
        {{--<div class="mb-3">--}}
            {{--<div class="form-check form-switch">--}}
                {{--<input class="form-check-input" type="checkbox" role="switch" id="active" name="active" value="0" {{ $f_active == 0 ? 'checked' : '' }}>--}}
                {{--<label class="form-check-label" for="active">@lang('app.pending')</label>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--@endauth--}}
    <div class="row g-3">
        <div class="col">
            <a href="{{ url()->current() }}" class="btn btn-secondary btn-sm w-100">
                @lang('app.clear')
            </a>
        </div>
        <div class="col">
            <button type="submit" class="btn btn-danger btn-sm w-100">
                <i class="bi-funnel"></i> @lang('app.filter')
            </button>
        </div>
    </div>
</form>