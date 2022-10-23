@if(($editor = ($editor ?? setting('forum.editor'))) === 'markdown')
    @push('styles')
        <link href="{{ asset('vendor/easymde/easymde.min.css') }}" rel="stylesheet">
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
                plugins: 'emoticons autolink code image link lists codesample paste',
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

                @if($dark ?? dark_theme())
                skin: 'oxide-dark',
                content_css: 'dark',
                @endif

                @isset($imagesUploadUrl)
                automatic_uploads: true,
                paste_data_images: true,
                images_replace_blob_uris: true,
                images_upload_handler: function (blobInfo, success, failure, progress) {
                    const formData = new FormData();
                    formData.append('file', blobInfo.blob(), blobInfo.filename());

                    axios.post('{{ $imagesUploadUrl }}', formData, {
                        onUploadProgress: function (progressEvent) {
                            if (progressEvent.lengthComputable) {
                                progress(progressEvent.loaded / progressEvent.total * 100);
                            }
                        },
                    }).then(function (response) {
                        success(response.data.location);
                    }).catch(function (error) {
                        tinymce.activeEditor.dom.doc.querySelectorAll('img[src^="blob:"]').forEach(function (img) {
                            tinymce.activeEditor.execCommand('mceRemoveNode', false, img);
                        });

                        if (error.response) {
                            failure(error.response.data.message);
                            return;
                        }

                        failure(error);
                    });
                },
                @endisset
            });
        </script>
    @else
        <script src="{{ asset('vendor/easymde/easymde.min.js') }}"></script>
        <script>
            document.querySelectorAll('textarea').forEach(function (el) {
                const easyMde = new EasyMDE({
                    element: el,
                    autoDownloadFontAwesome: true,
                    minHeight: '{{ $editorMinHeight ?? 300 }}px',
                    promptURLs: true,
                    spellChecker: false,
                    showIcons: ['strikethrough', 'code', '{{ isset($imagesUploadUrl) ? 'upload-image' : 'image' }}', 'horizontal-rule', 'undo', 'redo'],
                    status: false,

                    @isset($autosaveId)
                    autosave: {
                        enabled: true,
                        uniqueId: '{{ $autosaveId }}',
                    },
                    @endisset

                    @isset($imagesUploadUrl)
                    hideIcons: ['image'],
                    uploadImage: true,
                    imageAccept: '.jpg,.jpeg,.jpe,.png,.gif,.bmp,.svg,.webp',
                    imageUploadFunction: function (file, onSuccess, onError) {
                        if (file.size > easyMde.options.imageMaxSize) {
                            onError(easyMde.options.errorMessages.fileTooLarge);
                            return;
                        }

                        const formData = new FormData();
                        formData.append('file', file);

                        axios.post('{{ $imagesUploadUrl }}', formData, {
                            onUploadProgress: function (progressEvent) {
                                if (progressEvent.lengthComputable) {
                                    const progress = Math.round((progressEvent.loaded * 100) / progressEvent.total) + '';
                                    easyMde.updateStatusBar('upload-image', easyMde.options.imageTexts.sbProgress.replace('#file_name#', file.name).replace('#progress#', progress));
                                }
                            }
                        }).then(function (response) {
                            onSuccess(response.data.location);
                        }).catch(function (error) {
                            if (error.response) {
                                onError(error.response.data.message);
                                return;
                            }

                            onError(easyMde.options.errorMessages.importError);

                            console.error('Image upload error: ' + error);
                        });
                    },
                    @endisset
                });
            });
        </script>
    @endif
@endpush
