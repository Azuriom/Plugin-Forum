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
                toolbar: 'formatselect | bold italic underline strikethrough forecolor | link image emoticons | alignleft aligncenter alignright | bullist numlist | codesample blockquote | removeformat code | undo redo',
                relative_urls: false,
                convert_fonts_to_spans: false,
                formats: {
                    forecolor: { inline: 'font', attributes: { color: '%value' } },
                },
                valid_elements : 'strong/b,em/i,u,font[color],span[style],a[href],img[src|alt],center,p[style],blockquote,pre[class],code,h1,h2,h3,h4,h5,h6,ul,ol,li,br',
                valid_styles: {
                    span: 'text-decoration,color',
                    p: 'text-align',
                },
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
