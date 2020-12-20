@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/easymde@2.9.0/dist/easymde.min.css">
@endpush

@push('footer-scripts')
    <script src="https://cdn.jsdelivr.net/npm/easymde@2.9.0/dist/easymde.min.js"></script>
    <script>
        const markdownArea = document.querySelectorAll('textarea').forEach(function (el) {
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
@endpush
