@extends('layouts.app')
@section('title')
    @lang('app.appName')
@endsection
@section('content')
    @foreach($brandKitaps as $brandKitap)
        <div class="border-top">
            <div class="container-xl py-4">
                <div class="h5 mb-3">
                    <a href="{{ route('kitaps.index', ['brand' => $brandKitap['brand']->id]) }}" class="link-dark text-decoration-none">
                        {{ $brandKitap['brand']->name }}
                    </a>
                    <span class="text-secondary">({{ $brandKitap['brand']->kitaps_count }} @lang('app.kitaps'))</span>
                </div>
                <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4 g-4">
                    @foreach($brandKitap['kitaps'] as $kitap)
                        <div class="col">
                            @include('app.car')
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endforeach
@endsection