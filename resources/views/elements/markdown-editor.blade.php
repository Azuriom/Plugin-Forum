@if(($editor = ($editor ?? setting('forum.editor'))) === 'markdown')
    @push('styles')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/easymde@2.9.0/dist/easymde.min.css">
    @endpush
@endif

@push('footer-scripts')
    @if($editor !== 'markdown')
        <script src="{{ asset('vendor/tinymce/tinymce.min.js') }}"></script>
        <script>
            tinymce.init({
                selector: 'textarea',
                height: {{ ($editorMinHeight ?? 300) * 1.5 }},
                min_height: 200,
                entity_encoding: 'raw',
                menubar: false,
                plugins: 'emoticons autolink code image link lists codesample',
                toolbar: 'formatselect | bold italic underline strikethrough forecolor | link image emoticons | aligncenter | bullist numlist | codesample blockquote | removeformat code | undo redo',
                relative_urls: false,
                external_plugins: {
                    azuriombbcode: '{{ plugin_asset('forum', 'js/bbcode.js') }}',
                },
            });
        </script>
    @else
        <script src="https://cdn.jsdelivr.net/npm/easymde@2.9.0/dist/easymde.min.js"></script>
        <script>
            document.querySelectorAll('textarea').forEach(function (el) {
                new EasyMDE({
                    element: el,
                    autoDownloadFontAwesome: false,
                    minHeight: '{{ $editorMinHeight ?? 300 }}px',
                    promptURLs: true,
                    spellChecker: false,
                    showIcons: ['strikethrough', 'code', 'horizontal-rule', 'undo', 'redo'],
                    status: false,
                });
            });
        </script>
    @endif
@endpush
