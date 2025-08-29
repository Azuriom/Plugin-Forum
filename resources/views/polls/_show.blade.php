<div class="card mt-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">
            <i class="bi bi-bar-chart"></i> {{ $poll->question }}
        </h5>

        @can('delete', $poll)
            <form action="{{ route('forum.discussions.poll.destroy', $poll->discussion) }}" method="POST" class="d-inline"
                  onsubmit="return confirm('{{ trans('forum::messages.polls.delete_confirm') }}')">
                @csrf
                @method('DELETE')

                <button type="submit" class="btn btn-sm btn-danger" data-bs-toggle="tooltip" title="{{ trans('messages.actions.delete') }}">
                    <i class="bi bi-trash"></i>
                </button>
            </form>
        @endcan
    </div>

    <form class="card-body" action="{{ route('forum.discussions.poll.vote', $poll->discussion) }}" method="POST">
        @csrf

        @if($poll->hasVoted($user) || $poll->isClosed() || (request()->has('results') && $poll->results_before_vote))
            @foreach($poll->options as $option)
                <div class="row mb-1">
                    <div class="col-md-9">
                        <h6>{{ $option->value }}</h6>
                    </div>

                    <div class="col-md-3 text-end">
                        {{ trans_choice('forum::messages.polls.votes', $option->votes_count) }} ({{ $option->percentage() }}%)
                    </div>
                </div>

                <div class="progress mb-3" style="height: 0.5rem">
                    <div class="progress-bar" role="progressbar" style="width: {{ $option->percentage() }}%" aria-valuenow="{{ $option->percentage() }}" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            @endforeach
        @else
            @foreach($poll->options as $option)
                <div class="form-check mb-2">
                    <input class="form-check-input @error('options') is-invalid @enderror" type="{{ $poll->multiple_choice ? 'checkbox' : 'radio' }}"
                           value="{{ $option->id }}" id="option{{ $option->id }}" name="options[]" @guest disabled @endguest>

                    <label class="form-check-label" for="option{{ $option->id }}">
                        {{ $option->value }}
                    </label>
                </div>
            @endforeach

            @if($poll->multiple_choice)
                <p class="small text-muted mb-0">
                    {{ trans('forum::messages.polls.multiple') }}
                </p>
            @endif
        @endif

        <hr>

        <div class="d-flex justify-content-between align-items-center">
            <div>
                {{ trans_choice('forum::messages.polls.votes', $poll->votes()->count()) }}

                @if($poll->isClosed())
                    &middot; {{ trans('forum::messages.polls.closed') }}
                @elseif($poll->closes_at)
                    &middot; {{ trans('forum::messages.polls.closes', ['time' => $poll->closes_at->longAbsoluteDiffForHumans()]) }}
                @endif
            </div>

            <div>
                @if($poll->results_before_vote && ! $poll->isClosed() && ! $poll->hasVoted($user))
                    @if(request()->has('results'))
                        <a href="{{ route('forum.discussions.show', $poll->discussion) }}" class="btn btn-sm btn-secondary me-2">
                            <i class="bi bi-arrow-left"></i> {{ trans('forum::messages.polls.back') }}
                        </a>
                    @else
                        <a href="{{ route('forum.discussions.show', ['discussion' => $poll->discussion, 'results' => 1]) }}" class="btn btn-sm btn-secondary me-2">
                            <i class="bi bi-bar-chart"></i> {{ trans('forum::messages.polls.results') }}
                        </a>
                    @endif
                @endif

                @auth
                    @if($poll->canVote($user) && ! request()->has('results'))
                        <button type="submit" class="btn btn-sm btn-primary">
                            <i class="bi bi-check-circle"></i> {{ trans('forum::messages.polls.vote') }}
                        </button>
                    @elseif($poll->remove_vote && ! $poll->isClosed() && $poll->hasVoted($user))
                        @method('DELETE')

                        <button type="submit" class="btn btn-sm btn-secondary">
                            <i class="bi bi-arrow-counterclockwise"></i> {{ trans('forum::messages.polls.remove') }}
                        </button>
                    @endif
                @endauth
            </div>
        </div>
    </form>
</div>
