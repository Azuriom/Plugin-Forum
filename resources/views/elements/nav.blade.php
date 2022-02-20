<nav aria-label="breadcrumb">
    <ol class="breadcrumb bg-secondary bg-opacity-25 p-3 rounded">
        <li class="breadcrumb-item">
            <a href="{{ route('home') }}">
                {{ trans('messages.home') }}
            </a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ route('forum.home') }}">
                {{ trans('forum::messages.title') }}
            </a>
        </li>

        @foreach(($current ?? null)?->getNavigationStack() ?? [] as $breadcrumbLink => $breadcrumbName)
            <li class="breadcrumb-item">
                <a href="{{ $breadcrumbLink }}">
                    {{ $breadcrumbName }}
                </a>
            </li>
        @endforeach
    </ol>
</nav>
