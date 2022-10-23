@extends('layouts.app')

@section('content')
    @include('forum::elements.nav')

    <h1>@yield('title')</h1>

    @yield('forum')
@endsection
