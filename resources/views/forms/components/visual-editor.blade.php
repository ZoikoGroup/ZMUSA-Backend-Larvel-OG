<div
    x-data="{
        editor: null,
        initEditor() {
            const el = document.getElementById('{{ $getId() }}');

            this.editor = grapesjs.init({
                container: el,
                height: '{{ $getHeight() }}px',
                width: 'auto',
                fromElement: false,
                storageManager: false,
                plugins: ['gjs-blocks-basic'],
                pluginsOpts: {
                    'gjs-blocks-basic': {}
                }
            });

            // Load initial content
            let initial = @js($getState());
            if (initial) {
                this.editor.setComponents(initial);
            }

            // Sync with Livewire
            this.editor.on('update', () => {
                let html = this.editor.getHtml();
                $wire.set('{{ $getStatePath() }}', html);
            });
        }
    }"
    x-init="initEditor()"
    wire:ignore
>
    <style>
        #{{ $getId() }} {
            border: 1px solid #e5e7eb;
            min-height: {{ $getHeight() }}px;
            background: #fff;
        }
        .gjs-editor {
            background: white !important;
        }
    </style>

    <div id="{{ $getId() }}"></div>

    {{-- GrapesJS Core --}}
    <script src="https://unpkg.com/grapesjs@0.22.4/dist/grapes.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/grapesjs@0.22.4/dist/css/grapes.min.css">

    {{-- Missing Plugin (Fixes your error) --}}
    <script src="https://unpkg.com/grapesjs-blocks-basic"></script>
</div>
