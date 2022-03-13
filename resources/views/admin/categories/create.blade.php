@extends('admin.layouts.admin')

@section('title', trans('forum::admin.categories.create'))

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('forum.admin.categories.store') }}" method="POST">
                @include('forum::admin.categories._form')

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> {{ trans('messages.actions.save') }}
                </button>
            </form>
        </div>
    </div>
@endsection
