@extends('admin.layouts.admin')

@section('title', trans('forum::admin.categories.edit', ['category' => $category->name]))

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('forum.admin.categories.update', $category) }}" method="POST">
                @method('PUT')

                @include('forum::admin.categories._form')

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> {{ trans('messages.actions.save') }}
                </button>

                <a href="{{ route('forum.admin.categories.destroy', $category) }}" class="btn btn-danger" data-confirm="delete">
                    <i class="bi bi-trash"></i> {{ trans('messages.actions.delete') }}
                </a>
            </form>
        </div>
    </div>
@endsection
