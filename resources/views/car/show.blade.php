@extends('layouts.app')
@section('title')
    @lang('app.car') - @lang('app.appName')
@endsection
@section('content')
    <div class="container-xl py-4">
        @include('car.show.car')
        <div class="border-top">
            <div class="py-4">
                <hr>
                @if($similar == null)
                <div class="h5 mb-3">@lang('app.similar')</div>
                <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4 g-4">
                    @foreach($similar as $book)
                        <div class="col-6">
                            @include('app.car')
                        </div>
                    @endforeach
                </div>
                    @else
                    <div class="h5 mb-3">@lang('app.others')</div>
                    <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4 g-4">
                        @foreach($similar2 as $kitap)
                            <div class="col-6">
                                @include('app.car')
                            </div>
                        @endforeach
                    </div>

                @endif
            </div>
        </div>
    </div>
@endsection