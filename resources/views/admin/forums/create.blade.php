@extends('admin.layouts.admin')

@section('title', trans('forum::admin.forums.create'))

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('forum.admin.forums.store') }}" method="POST">
                @include('forum::admin.forums._form')

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> {{ trans('messages.actions.save') }}
                </button>
            </form>
        </div>
    </div>
@endsection
