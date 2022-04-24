<li class="sortable-item" data-forum-id="{{ $forum->id }}">
    <div class="card">
        <div class="card-body d-flex justify-content-between">
            <span>
                <i class="bi bi-arrows-move sortable-handle"></i>
                <a href="{{ route('forum.show', $forum->slug) }}">{{ $forum->name }}</a>
            </span>
            <span>
                <a href="{{ route('forum.admin.forums.edit', $forum) }}" class="mx-1" title="{{ trans('messages.actions.edit') }}" data-bs-toggle="tooltip"><i class="bi bi-pencil-square"></i></a>
                <a href="{{ route('forum.admin.forums.destroy', $forum) }}" class="mx-1" title="{{ trans('messages.actions.delete') }}" data-bs-toggle="tooltip" data-confirm="delete"><i class="bi bi-trash"></i></a>
            </span>
        </div>
    </div>

    <ol class="list-unstyled sortable sortable-list forum-list">
        @each('forum::admin.forums._forum', $forum->forums, 'forum')
    </ol>
</li>
