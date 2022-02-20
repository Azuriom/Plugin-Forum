@extends('admin.layouts.admin')

@section('title', trans('forum::admin.forums.title'))

@push('footer-scripts')
    <script src="{{ asset('vendor/sortablejs/Sortable.min.js') }}"></script>
    <script>
        const sortable = Sortable.create(document.getElementById('categories'), {
            group: {
                name: 'categories',
            },
            animation: 150,
            handle: '.sortable-handle'
        });

        document.querySelectorAll('.forum-list').forEach(function (el) {
            Sortable.create(el, {
                group: {
                    name: 'forums',
                },
                animation: 150,
                handle: '.sortable-handle'
            });
        });

        function serialize(categories) {
            return [].slice.call(categories.children).map(function (category) {
                return {
                    id: category.dataset['categoryId'],
                    forums: serializeForum(category.querySelector('.forum-list')),
                };
            });
        }

        function serializeForum(forumsList) {
            return [].slice.call(forumsList.children).map(function (forumCategory) {
                return {
                    id: forumCategory.dataset['forumId'],
                    forums: serializeForum(forumCategory.querySelector('.forum-list')),
                };
            });
        }

        const saveButton = document.getElementById('save');
        const saveButtonIcon = saveButton.querySelector('.btn-spinner');

        saveButton.addEventListener('click', function () {
            saveButton.setAttribute('disabled', '');
            saveButtonIcon.classList.remove('d-none');

            axios.post('{{ route('forum.admin.forums.update-order') }}', {
                'categories': serialize(sortable.el)
            })
                .then(function (json) {
                    createAlert('success', json.data.message, true);
                })
                .catch(function (error) {
                    createAlert('danger', error, true)
                })
                .finally(function () {
                    saveButton.removeAttribute('disabled');
                    saveButtonIcon.classList.add('d-none');
                });
        });
    </script>
@endpush

@section('content')
    <div class="card">
        <div class="card-body">

            <ol class="list-unstyled sortable" id="categories">
                @foreach($categories as $category)
                    <li class="sortable-item sortable-dropdown mb-5" data-category-id="{{ $category->id }}">
                        <div class="card">
                            <div class="card-body d-flex justify-content-between">
                                <span>
                                    <i class="fas fa-arrows-alt sortable-handle"></i> {{ $category->name }}
                                </span>
                                <span>
                                    <a href="{{ route('forum.admin.categories.edit', $category) }}" class="mx-1" title="{{ trans('messages.actions.edit') }}" data-bs-toggle="tooltip"><i class="fas fa-edit"></i></a>
                                    <a href="{{ route('forum.admin.categories.destroy', $category) }}" class="mx-1" title="{{ trans('messages.actions.delete') }}" data-bs-toggle="tooltip" data-confirm="delete"><i class="fas fa-trash"></i></a>
                                </span>
                            </div>
                        </div>

                        <ol class="list-unstyled sortable sortable-list forum-list">
                            @each('forum::admin.forums._forum', $category->forums, 'forum')
                        </ol>
                    </li>
                @endforeach
            </ol>

            <a href="{{ route('forum.admin.categories.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> {{ trans('forum::admin.forums.create_category') }}
            </a>

            @if(! $categories->isEmpty())
                <a href="{{ route('forum.admin.forums.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> {{ trans('forum::admin.forums.create_forum') }}
                </a>

                <button type="button" class="btn btn-success" id="save">
                    <i class="fas fa-save"></i> {{ trans('messages.actions.save') }}
                    <span class="spinner-border spinner-border-sm btn-spinner d-none" role="status"></span>
                </button>
            @endif
        </div>
    </div>
@endsection
