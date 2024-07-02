@extends('layouts.app')
@section('title')
    @lang('app.search') - @lang('app.appName')
@endsection
@section('content')
    <div class="container-xl py-4">
        <div class="row g-4">
            <div class="col-6 col-md-4 col-xl-3">
                @include('app.filter')
            </div>
            <div class="col">
                <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-4 mb-4">
                    @foreach($books as $book)
                        <div class="col">
                            @include('app.car')
                        </div>
                    @endforeach
                </div>
                {{ $books->links() }}
            </div>
        </div>
    </div>
@endsection