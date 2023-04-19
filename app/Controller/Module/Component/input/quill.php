<div class="mb-3">
    <label class="small mb-1" for="$this->replace->id">{{$this->replace->label}}</label>
    <!-- Create toolbar container -->
    <div class="form-control" id="toolbar-$this->replace->id">
    <span class="ql-formats">
        <select class="ql-font"></select>
        <select class="ql-size"></select>
    </span>
        <span class="ql-formats">
        <button class="ql-bold"></button>
        <button class="ql-italic"></button>
        <button class="ql-underline"></button>
        <button class="ql-strike"></button>
    </span>
        <span class="ql-formats">
        <select class="ql-color"></select>
        <select class="ql-background"></select>
    </span>
        <span class="ql-formats">
        <button class="ql-script" value="sub"></button>
        <button class="ql-script" value="super"></button>
    </span>
        <span class="ql-formats">
        <button class="ql-header" value="1"></button>
        <button class="ql-header" value="2"></button>
        <button class="ql-blockquote"></button>
        <button class="ql-code-block"></button>
    </span>
        <span class="ql-formats">
        <button class="ql-list" value="ordered"></button>
        <button class="ql-list" value="bullet"></button>
        <button class="ql-indent" value="-1"></button>
        <button class="ql-indent" value="+1"></button>
    </span>
        <span class="ql-formats">
        <button class="ql-direction" value="rtl"></button>
        <select class="ql-align"></select>
    </span>
        <span class="ql-formats">
        <button class="ql-link"></button>
        <button class="ql-image"></button>
        <button class="ql-video"></button>
        <button class="ql-formula"></button>
    </span>
        <span class="ql-formats">
        <button class="ql-clean"></button>
    </span>
        <span class="ql-formats">
        <button type="button" id="btn-fullscreen" title="{{Fullscreen}}"><i class="fas fa-expand"></i></button>
        </span>
    </div>

    <div class="form-control" id="$this->replace->id">
        {{ $this->replace->value }}
    </div>
</div>
<script>
    let quill = new Quill('#$this->replace->id', {
        modules: {
            syntax: true,
            toolbar: '#toolbar-$this->replace->id'
        },
        theme: 'snow', // or 'bubble'
        name: '$this->replace->name'
    });

    document.getElementById('btn-fullscreen').addEventListener('click', () => {
        let editorContainer = document.getElementById('$this->replace->id').parentNode;
        let isFullscreen = editorContainer.classList.contains('editor-fullscreen');

        if (isFullscreen) {
            editorContainer.classList.remove('editor-fullscreen');
            document.body.style.overflow = 'auto';
        } else {
            editorContainer.classList.add('editor-fullscreen');
            document.body.style.overflow = 'hidden';
        }
    });
</script>
<script>
    // ... seu código Quill existente ...

    function uploadImage(image) {
        return new Promise((resolve, reject) => {
            // Substitua esta URL pelo endpoint do seu servidor para processar o upload da imagem
            const apiUrl = "{{TEMPLATE_URL}}{{#/posts/image/upload#}}";
            const formData = new FormData();
            formData.append("image", image);

            $.ajax({
                url: apiUrl,
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    resolve(response); // A resposta do servidor deve conter o URL da imagem
                },
                error: function (error) {
                    reject(error);
                },
            });
        });
    }

    quill.getModule("toolbar").addHandler("image", () => {
        const input = document.createElement("input");
        input.setAttribute("type", "file");
        input.setAttribute("accept", "image/*");
        input.click();

        input.onchange = async () => {
            const file = input.files[0];
            try {
                const imageUrl = await uploadImage(file);
                const range = quill.getSelection(true);
                quill.insertEmbed(range.index, "image", imageUrl);
                quill.setSelection(range.index + 1);
            } catch (error) {
                console.error("Error uploading image:", error);
            }
        };
    });
</script>
