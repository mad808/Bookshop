@extends('layouts.app')
@section('title') {{ $book->name }} - @lang('app.edit') @endsection
@section('content')
    <div class="container-xxl py-3">
        <div class="d-block h3 text-dark fw-bold text-center border-bottom py-2 mb-3">
            {{ $book->name }} - @lang('app.edit')
        </div>
        <div class="row justify-content-center">
            <form action="{{ route('books.update', $book->id) }}" method="post" enctype="multipart/form-data" class="col-md-6 col-lg-4">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="brand_id" class="form-label fw-bold">
                        @lang('app.brand') <span class="text-danger">*</span>
                    </label>
                    <select class="form-select @error('brand_id') is-invalid @enderror" id="brand_id" name="brand_id" required>
                        @foreach($brands as $brand)
                            <option value="{{ $brand->id }}" {{ $brand->id == $book->brand_id ? 'selected':'' }}>
                                {{ $brand->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('brand_id')
                    <div class="alert alert-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="booklang_id" class="form-label fw-bold">
                        @lang('app.color') <span class="text-danger">*</span>
                    </label>
                    <select class="form-select @error('booklang_id') is-invalid @enderror" id="booklang_id" name="booklang_id" required autofocus>
                        @foreach($booklangs as $booklang)
                            <option value="{{ $booklang->id }}" {{ $booklang->id == $book->booklang_id ? 'selected':'' }}>
                                {{ $booklang->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('booklang_id')
                    <div class="alert alert-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>


                <div class="mb-3">
                    <label for="name" class="form-label fw-bold">
                        @lang('app.name')
                    </label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" value="{{ $book->name }}">
                    @error('name')
                    <div class="alert alert-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>


                <div class="mb-3">
                    <label for="bar_code" class="form-label fw-bold">
                        @lang('app.bar_code') <span class="text-danger">*</span>
                    </label>
                    <input type="text" class="form-control @error('bar_code') is-invalid @enderror" name="bar_code" id="bar_code" value="{{ $book->bar_code }}" maxlength="255" required>
                    @error('bar_code')
                    <div class="alert alert-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label fw-bold">
                        @lang('app.description')
                    </label>
                    <textarea class="form-control @error('description') is-invalid @enderror" name="description" id="description" rows="3" maxlength="2550">{{ $book->description }}</textarea>
                    @error('description')
                    <div class="alert alert-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>


                <div class="mb-3">
                    <label for="price" class="form-label fw-bold">
                        @lang('app.pagecount') <span class="text-danger">*</span>
                    </label>
                    <input type="number" class="form-control @error('bookspage') is-invalid @enderror" name="bookspage" id="price" value="{{ $book->bookspage }}" min="0" step="0.1" required>
                    @error('bookspage')
                    <div class="alert alert-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="price" class="form-label fw-bold">
                        @lang('app.price') <span class="text-danger">*</span>
                    </label>
                    <input type="number" class="form-control @error('price') is-invalid @enderror" name="price" id="price" value="{{ $book->price }}" min="0" step="0.1" required>
                    @error('price')
                    <div class="alert alert-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>



                <div class="mb-3">
                    <label for="image" class="form-label fw-bold">@lang('app.image') (500x500)</label>
                    <input class="form-control @error('image') is-invalid @enderror" type="file" name="image" id="image" accept="image/jpeg">
                    @error('image')
                    <div class="alert alert-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check2-circle"></i> @lang('app.update')
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection