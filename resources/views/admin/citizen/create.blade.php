@extends('admin.layouts.app')
@section('title')
    @lang('app.book')
@endsection
@section('content')
    <div class="h6 p-2">
        <a href="{{ route('admin.dashboard') }}" class="text-decoration-none green">
            @lang('app.dashboard')
        </a>
        <i class="bi-chevron-right small"></i>
        <a href="{{ route('admin.books.index') }}" class="text-decoration-none green">
            @lang('app.books')
        </a>
        <i class="bi-chevron-right small"></i>
        @lang('app.add')
    </div>

    <div class="row mb-3 justify-content-center">
        <div class="bg-body-tertiary rounded-3 m-3 p-3 text-center col-11">
            <form action="{{ route('admin.books.store') }}" enctype="multipart/form-data" method="post">
                @csrf
                <div class="d-flex align-items-center justify-content-center">
                    <div class="col-3 m-3">
                        <label for="name" class="form-label fw-bold">
                            @lang('app.name')
                            <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                               id="name" value="{{ old('name') }}" maxlength="16" required autofocus>
                        @error('name')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-3 m-3">
                        <label for="secondName" class="form-label fw-bold">
                            @lang('app.secondName')
                            <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control @error('secondName') is-invalid @enderror"
                               name="secondName"
                               id="secondName" value="{{ old('secondName') }}" maxlength="16" required>
                        @error('secondName')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-3 m-3">
                        <label for="thirdName" class="form-label fw-bold">
                            @lang('app.thirdName')
                        </label>
                        <input type="text" class="form-control @error('thirdName') is-invalid @enderror"
                               name="thirdName"
                               id="thirdName" value="{{ old('thirdName') }}" maxlength="16">
                        @error('thirdName')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="d-flex align-items-center justify-content-center">
                    <div class="col-3 m-3">
                        <label for="phone" class="form-label fw-bold">
                            @lang('app.phone')
                            <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text">+993</span>
                            <input class="form-control" type="number" placeholder="@lang('app.phone')" name="phone"
                                   id="phone" value="{{ old('phone') }}"
                                   min="61000000" max="65999999">
                        </div>
                        @error('phone')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-3 m-3">
                        <label for="country" class="form-label fw-bold">
                            @lang('app.country')
                            <span class="text-danger">*</span>
                        </label>
                        <select class="form-select @error('country') is-invalid @enderror" name="country" id="country"
                                required>
                            <option value="1" {{ old('country')  == 1 ? 'selected' : ''}}>@lang('app.ashgabat')</option>
                            <option value="2" {{ old('country') == 2 ? 'selected' : ''}}>@lang('app.lebap')</option>
                            <option value="3" {{ old('country') == 3 ? 'selected' : ''}}>@lang('app.mary')</option>
                            <option value="4" {{ old('country') == 4 ? 'selected' : ''}}>@lang('app.balkan')</option>
                            <option value="5" {{ old('country') == 5 ? 'selected' : ''}}>@lang('app.ahal')</option>
                            <option value="6" {{ old('country') == 6 ? 'selected' : ''}}>@lang('app.dashoguz')</option>
                        </select>
                        @error('country')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-3 m-3">
                        <label for="passport" class="form-label fw-bold">
                            @lang('app.passport')
                            <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control @error('passport') is-invalid @enderror"
                               name="passport"
                               id="passport" value="{{ old('passport') }}" maxlength="11" required>
                        @error('passport')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="d-flex align-items-center justify-content-center">

                    <div class="col-3 m-3">
                        <label for="birthday" class="form-label fw-bold">
                            @lang('app.birthday')
                            <span class="text-danger">*</span>
                        </label>
                        <input type="date" class="form-control @error('birthday') is-invalid @enderror"
                               name="birthday"
                               id="birthday" required>
                        <script>
                            @php()
                                $birthday = "old('birthday')"
                            document.getElementById("birthday").value = "{!! $birthday->format('Y-m-d') !!}";
                            @endphp
                        </script>
                        @error('birthday')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-3 m-3">
                        <label for="image" class="form-label fw-bold">
                            @lang('app.image')
                        </label>
                        <input type="file" class="form-control @error('image') is-invalid @enderror"
                               name="image"
                               id="image" value="{{ old('image') }}">
                        @error('image')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-3 m-3">
                        <label for="gender" class="form-label fw-bold">
                            @lang('app.gender')
                            <span class="text-danger">*</span>
                        </label>
                        <select class="form-select @error('gender') is-invalid @enderror" name="gender" id="gender"
                                required>
                            <option value="1" {{ old('gender') == 1 ? 'selected' : ''}}>@lang('app.male')</option>
                            <option value="2" {{ old('gender') == 2 ? 'selected' : ''}}>@lang('app.female')</option>
                        </select>
                        @error('gender')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                </div>

                <button type="submit" class="btn btn-primary">
                    @lang('app.create')
                </button>
            </form>
        </div>
@endsection
