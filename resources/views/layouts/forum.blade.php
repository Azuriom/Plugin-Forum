@extends('layouts.app')

@section('content')
    @include('forum::elements.nav')

    @if(($withSearch ?? false) || ($includeTitle ?? true))
        <div class="row row-cols-lg-auto justify-content-between">
            @if($includeTitle ?? true)
                <h1>@yield('title')</h1>
            @endif

            @if($withSearch ?? false)
                <form class="col-12 mb-3" method="GET">
                    <label class="visually-hidden" for="searchInput">
                        {{ trans('messages.actions.search') }}
                    </label>

                    <div class="input-group">
                        <input type="search" class="form-control" id="searchInput" name="search" value="{{ $search ?? '' }}" placeholder="{{ trans('messages.actions.search') }}">

                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </form>
            @endif
        </div>
    @endif

    @yield('forum')
@endsection
