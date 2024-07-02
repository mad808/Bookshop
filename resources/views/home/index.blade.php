@extends('layouts.app')
@section('title')
    @lang('app.appName')
@endsection
@section('content')
    @foreach($brandBooks as $brandBook)
        <div class="border-top">
            <div class="container-xl py-4">
                <div class="h5 mb-3">
                    <a href="{{ route('books.index', ['brand' => $brandBook['brand']->id]) }}" class="link-dark text-decoration-none">
                        {{ $brandBook['brand']->name }}
                    </a>
                    <span class="text-secondary">({{ $brandBook['brand']->books_count }} @lang('app.kitaps'))</span>
                </div>
                <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4 g-4">
                    @foreach($brandBook['books'] as $book)
                        <div class="col">
                            @include('app.car')
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endforeach
@endsection