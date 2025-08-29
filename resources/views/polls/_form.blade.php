@if(($discussion->poll ?? null) === null)
    @include('admin.elements.date-picker', ['wrap' => true])

    @can('forum.polls.create')
        <div class="mb-4 form-check form-switch">
            <input type="checkbox" class="form-check-input" id="pollSwitch" name="poll"
                   data-bs-toggle="collapse" data-bs-target="#pollGroup" @checked(old('poll'))>
            <label class="form-check-label" for="pollSwitch">
                {{ trans('forum::messages.polls.create') }}
            </label>
        </div>

        <div id="pollGroup" class="{{ old('poll') ? 'show' : 'collapse' }}">
            <div class="mb-3">
                <label class="form-label" for="pollQuestion">{{ trans('forum::messages.polls.question') }}</label>
                <input type="text" class="form-control @error('question') is-invalid @enderror" id="pollQuestion" name="question" value="{{ old('question') }}">

                @error('question')
                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">{{ trans('forum::messages.polls.options') }}</label>

                <div id="pollOptions">
                    @foreach(old('options') ?? ['', ''] as $option)
                        <div class="input-group mb-2">
                            <input type="text" class="form-control @error('options') is-invalid @enderror" name="options[]" placeholder="{{ trans('forum::messages.polls.option') }}" value="{{ $option }}">

                            <button type="button" class="btn btn-danger" data-option="remove" onclick="removePollOption(this)" title="{{ trans('messages.actions.delete') }}">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    @endforeach
                </div>

                <button type="button" class="btn btn-outline-primary btn-sm" data-option="add" onclick="addPollOption()">
                    <i class="bi bi-plus-lg"></i> {{ trans('messages.actions.add') }}
                </button>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="multipleChoice" name="multiple_choice" @checked(old('multiple_choice'))>
                        <label class="form-check-label" for="multipleChoice">{{ trans('forum::messages.polls.multiple_choice') }}</label>
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="resultsBeforeVote" name="results_before_vote" @checked(old('results_before_vote'))>
                        <label class="form-check-label" for="resultsBeforeVote">{{ trans('forum::messages.polls.results_before_vote') }}</label>
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="removeVote" name="remove_vote" @checked(old('remove_vote'))>
                        <label class="form-check-label" for="removeVote">{{ trans('forum::messages.polls.remove_vote') }}</label>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label" for="pollClosesAt">{{ trans('forum::messages.polls.close') }}</label>

                        <div class="input-group date-picker @error('closes_at') has-validation @enderror">
                            <input type="text" class="form-control @error('closes_at') is-invalid @enderror" id="pollClosesAt" name="closes_at" value="{{ old('closes_at') }}" data-input>

                            <button type="button" class="btn btn-outline-danger" title="{{ trans('messages.actions.remove') }}" data-clear>
                                <i class="bi bi-x-lg"></i>
                            </button>

                            @error('closes_at')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <div class="form-text">{{ trans('forum::messages.polls.close_info') }}</div>
                    </div>
                </div>
            </div>
        </div>
    @endcan
@endif

@push('scripts')
    <script>
        function addPollOption() {
            const pollOptions = document.getElementById('pollOptions');

            const newOption = document.createElement('div');
            newOption.classList.add('input-group', 'mb-2');
            newOption.innerHTML = pollOptions.firstElementChild.innerHTML;
            newOption.querySelector('input').value = '';
            pollOptions.appendChild(newOption);

            updateButtonVisibility();
        }

        function removePollOption(button) {
            button.parentElement.remove();

            updateButtonVisibility();
        }

        function updateButtonVisibility() {
            const options = document.querySelectorAll('#pollOptions .input-group').length;

            document.querySelectorAll('[data-option]').forEach(function (button) {
                const type = button.dataset.option;

                // Show add button if less than 10 options, and remove button if at least 2 options
                if ((type === 'remove' && options <= 2) || (type === 'add' && options >= 10)) {
                    button.classList.add('d-none');
                } else {
                    button.classList.remove('d-none');
                }
            });
        }

        document.addEventListener('DOMContentLoaded', updateButtonVisibility);
    </script>
@endpush
