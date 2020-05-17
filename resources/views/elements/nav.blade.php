<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ trans('messages.home') }}</a></li>
        <li class="breadcrumb-item"><a href="{{ route('forum.home') }}">{{ trans('forum::messages.title') }}</a></li>

        @foreach(optional($current ?? null)->getNavigationStack() ?? [] as $breadcrumbLink => $breadcrumbName)
            <li class="breadcrumb-item"><a href="{{ $breadcrumbLink }}">{{ $breadcrumbName }}</a></li>
        @endforeach
    </ol>
</nav>

@push('styles')
    <style>
        .forum-big-icon i {
            font-size: 3em;
        }

        @media (max-width: 575px) {
            .forum-big-icon {
                padding-left: 5px;
                padding-right: 0;
            }

            .forum-big-icon i {
                font-size: 2em;
            }
        }
    </style>
@endpush
