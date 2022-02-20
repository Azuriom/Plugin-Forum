@extends('admin.layouts.admin')

@section('title', trans('forum::admin.forums.title'))

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('forum.admin.tags.update', $tag) }}" method="POST">
                @method('PUT')

                @include('forum::admin.tags._form')

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> {{ trans('messages.actions.save') }}
                </button>

                <a href="{{ route('forum.admin.tags.destroy', $tag) }}" class="btn btn-danger" data-confirm="delete">
                    <i class="fas fa-trash"></i> {{ trans('messages.actions.delete') }}
                </a>
            </form>
        </div>
    </div>
@endsection
