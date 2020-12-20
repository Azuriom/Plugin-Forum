@extends('admin.layouts.admin')

@section('title', trans('forum::admin.tags.title'))

@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        {{ trans('forum::admin.tags.create') }}
                    </h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('forum.admin.tags.store') }}" method="POST">
                        @include('forum::admin.tags._form')

                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> {{ trans('messages.actions.save') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>

        @if(! $tags->isEmpty())
            <div class="col-md-6">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            {{ trans('forum::admin.tags.title') }}
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">{{ trans('messages.fields.name') }}</th>
                                    <th scope="col">{{ trans('messages.fields.action') }}</th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($tags as $tag)
                                    <tr>
                                        <th scope="row">{{ $tag->id }}</th>
                                        <td>
                                            <span class="badge" style="{{ $tag->getBadgeStyle() }}">
                                                {{ $tag->name }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('forum.admin.tags.edit', $tag) }}" class="mx-1" title="{{ trans('messages.actions.edit') }}" data-toggle="tooltip"><i class="fas fa-edit"></i></a>
                                            <a href="{{ route('forum.admin.tags.destroy', $tag) }}" class="mx-1" title="{{ trans('messages.actions.delete') }}" data-toggle="tooltip" data-confirm="delete"><i class="fas fa-trash"></i></a>
                                        </td>
                                    </tr>
                                @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
