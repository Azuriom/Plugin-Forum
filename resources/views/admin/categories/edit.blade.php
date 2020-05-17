@extends('admin.layouts.admin')

@section('title', trans('forum::admin.categories.title-edit', ['category' => $category->name]))

@section('content')
    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('forum.admin.categories.update', $category) }}" method="POST">
                @method('PUT')

                @include('forum::admin.categories._form')

                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> {{ trans('messages.actions.save') }}</button>
                <a href="{{ route('forum.admin.categories.destroy', $category) }}" class="btn btn-danger" data-confirm="delete"><i class="fas fa-trash"></i> {{ trans('messages.actions.delete') }}</a>
            </form>
        </div>
    </div>
@endsection
