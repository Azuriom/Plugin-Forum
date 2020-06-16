<li class="sortable-item" data-forum-id="{{ $forum->id }}">
    <div class="card">
        <div class="card-body d-flex justify-content-between">
            <span>
                <i class="fas fa-arrows-alt sortable-handle"></i>
                <a href="{{ route('forum.show', $forum->slug) }}">{{ $forum->name }}</a>
            </span>
            <span>
                <a href="{{ route('forum.admin.forums.edit', $forum) }}" class="mx-1" title="{{ trans('messages.actions.edit') }}" data-toggle="tooltip"><i class="fas fa-edit"></i></a>
                <a href="{{ route('forum.admin.forums.destroy', $forum) }}" class="mx-1" title="{{ trans('messages.actions.delete') }}" data-toggle="tooltip" data-confirm="delete"><i class="fas fa-trash"></i></a>
            </span>
        </div>
    </div>

    <ol class="list-unstyled sortable sortable-list forum-list">
        @each('forum::admin.forums._forum', $forum->forums, 'forum')
    </ol>
</li>
