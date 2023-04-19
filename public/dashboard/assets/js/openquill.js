function openquill(idquill, namequill, toolbar, source, endpointUpload)
{
    let quill = new Quill(idquill, {
        modules: {
            syntax: true,
            toolbar: toolbar
        },
        theme: 'snow', // or 'bubble'
        name: namequill
    });
    let quillSource = new Quill(source, {
        theme: 'snow',
        modules: {
            toolbar: false,
        },
        readOnly: false,
    });
    let toggleSourceButton = document.getElementById("toggle-source");
    let sourceTextArea = document.createElement("textarea");
    let isCodeMode = false;
    let codeMirrorEditor;
    sourceTextArea.style.display = "none";
    sourceTextArea.style.width = "100%";
    sourceTextArea.style.height = "300px";
    sourceTextArea.style.overflow = "auto";
    sourceTextArea.style.border = "none";
    document.getElementById('btn-fullscreen').addEventListener('click', () => {
        let editorContainer = document.getElementById(idquill).parentNode;
        let isFullscreen = editorContainer.classList.contains('editor-fullscreen');

        if (isFullscreen) {
            editorContainer.classList.remove('editor-fullscreen');
            document.body.style.overflow = 'auto';
            if (codeMirrorEditor) {
                codeMirrorEditor.setSize(null, "300px");
            }
        } else {
            editorContainer.classList.add('editor-fullscreen');
            document.body.style.overflow = 'hidden';
            if (codeMirrorEditor) {
                codeMirrorEditor.setSize(null, "100%");
            }
        }
    });
    toggleSourceButton.onclick = () => {
        const quillContainer = document.querySelector(".ql-container");
        const quillEditor = quillContainer.querySelector(".ql-editor");
        const toggleIcon = toggleSourceButton.querySelector('.toggle-source-icon');

        if (!isCodeMode) {
            isCodeMode = true;
            const html = quill.root.innerHTML;
            sourceTextArea.innerHTML = html;
            if (!quillContainer.contains(sourceTextArea)) {
                quillContainer.appendChild(sourceTextArea);
            }
            quillEditor.style.display = "none";
            sourceTextArea.style.display = "block";

            // Inicializar o editor CodeMirror
            codeMirrorEditor = CodeMirror.fromTextArea(sourceTextArea, {
                mode: "text/html",
                theme: "monokai",
                lineNumbers: true,
                lineWrapping: true, // Quebra de linha
                autoCloseTags: true,
                matchBrackets: true,
                extraKeys: {"Ctrl-Space": "autocomplete"},
                value: html
            });

            toggleIcon.innerHTML = '<i class="fas fa-close" style="width: 20px"></i>';
        } else {
            isCodeMode = false;
            const html = codeMirrorEditor.getValue();
            quill.root.innerHTML = html;
            codeMirrorEditor.toTextArea(); // Converter o editor CodeMirror de volta para um textarea
            sourceTextArea.style.display = "none";
            quillEditor.style.display = "block";
            toggleIcon.innerHTML = '<i class="fas fa-code" style="width: 20px"></i>';
        }
    };
    quill.getModule("toolbar").addHandler("image", () => {
        const input = document.createElement("input");
        input.setAttribute("type", "file");
        input.setAttribute("accept", "image/*");
        input.click();

        input.onchange = async () => {
            const file = input.files[0];
            try {
                const imageUrl = await uploadImage(file, endpointUpload);
                const range = quill.getSelection(true);
                quill.insertEmbed(range.index, "image", imageUrl);
                quill.setSelection(range.index + 1);
            } catch (error) {
                console.error("Error uploading image:", error);
            }
        };
    });
}