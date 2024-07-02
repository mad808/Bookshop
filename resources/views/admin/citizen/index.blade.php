@extends('admin.layouts.app')
@section('title')
    @lang('app.books')
@endsection
@section('content')
    <div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">
            @lang('app.books')
        </h1>
        <form action="{{ url()->current() }}">
            <div>
                <div class="d-flex align-items-center justify-content-center">
                        <input type="search"  name="q" class="form-control form-control-sm me-2 " placeholder="{{ @trans('app.search') }}" aria-label="{{ @trans('app.search') }}" aria-describedby="basic-addon2">
                    <select class="form-select form-select-sm" name="sort" id="sort">
                        <option
                            value="by-alphabet">@lang('app.by-alphabet')</option>
                        <option
                            value="start-to-end">@lang('app.start-to-end')</option>
                        <option
                            value="end-to-start">@lang('app.end-to-start')</option>
                        <option
                            value="top-to-bottom">@lang('app.top-to-bottom')</option>
                        <option
                            value="bottom-to-top">@lang('app.bottom-to-top')</option>
                    </select>
                    <select class="form-select form-select-sm mx-2" name="perPage" id="perPage">
                        @foreach([10, 25, 50, 100] as $perPage)
                            <option
                                value="{{ $perPage }}" {{ $perPage == $f_perPage ? 'selected' : '' }}>{{ $perPage }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="btn btn-info btn-sm d-flex"><i
                            class="bi-search"></i> @lang('app.search')
                    </button>
                    <div class="mx-2">
                        <a href="{{ url()->current() }}" class="btn btn-secondary btn-sm d-flex">
                            <i class="bi-trash"></i> @lang('app.clear')
                        </a>
                    </div>
                    <a href="{{ route('admin.books.create') }}"
                       class="btn btn-danger btn-sm text-decoration-none d-flex">
                        <i class="bi-plus-lg"></i> @lang('app.add')
                    </a>
                </div>
            </div>
        </form>
    </div>

    <div class="table-responsive">
        <table class="table table-hover table-striped text-center">
            <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">@lang('app.image')</th>
                <th scope="col">@lang('app.name')</th>
                <th scope="col">@lang('app.brand')</th>
                <th scope="col">@lang('app.lang')</th>
                <th scope="col">@lang('app.year')</th>
                <th scope="col">@lang('app.price')</th>

                <th scope="col"><i class="bi-gear-fill"></i></th>
            </tr>
            </thead>
            <tbody>
            @foreach($objs as $obj)
                <tr>
                    <td>{{ $obj->id }}</td>
                    <td><img class="rounded" width="75" height="75" src="{{$obj->image()}}"></td>

                    <td><a class="text-decoration-none text-primary">{{ $obj->name }}</a></td>
                    <td><a class="text-decoration-none text-primary">{{ $obj->brand->name }}</a></td>
                    <td><a class="text-decoration-none text-primary">{{ $obj->booklang->name }}</a></td>
                    <td><a class="text-decoration-none text-primary">{{ $obj->year->name }}</a></td>
                    <td><a class="text-decoration-none text-primary">{{ $obj->price }}</a></td>
{{--                    <td><a class="text-decoration-none text-primary">{{ $obj->description }}</a></td>--}}

                    {{--<td>{{ $obj->passport }}</td>--}}

                    <td>
                        <a href="{{ route('admin.books.show', $obj->id) }}" class="btn btn-info btn-sm my-1">
                            <i class="bi-eye-fill"></i>
                        </a>
                        <a href="{{ route('admin.books.edit', $obj->id) }}" class="btn btn-success btn-sm my-1">
                            <i class="bi-pencil"></i>
                        </a>
                        <button type="button" class="btn btn-secondary btn-sm my-1" data-bs-toggle="modal"
                                data-bs-target="#delete{{ $obj->id }}">
                            <i class="bi-trash"></i>
                        </button>
                        <div class="modal fade" id="delete{{ $obj->id }}" tabindex="-1"
                             aria-labelledby="delete{{ $obj->id }}Label" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <div class="modal-title fs-5 fw-bold" id="delete{{ $obj->id }}Label">
                                            {{ $obj->id }}.{{ $obj->secondName }} {{ $obj->name }}
                                        </div>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        @lang('app.delete-question')
                                    </div>
                                    <div class="modal-footer">
                                        <form action="{{ route('admin.books.destroy', $obj->id) }}" method="post">
                                            @method('DELETE')
                                            @csrf
                                            <button type="submit" class="btn btn-secondary btn-sm"><i
                                                        class="bi-trash"></i> @lang('app.delete')</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
