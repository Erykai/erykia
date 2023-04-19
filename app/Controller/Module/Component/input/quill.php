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
            <button type="button" id="toggle-source" title="Toggle Source"><span class="toggle-source-icon">
            <i class="fas fa-code" style="width: 20px"></i></span>
            </button>
        </span>
        <span class="ql-formats">
            <button type="button" id="btn-fullscreen" title="{{Fullscreen}}">
                <i class="fas fa-expand" style="width: 20px"></i>
            </button>
        </span>
    </div>

    <div class="form-control" id="$this->replace->id">
        {{ $this->replace->value }}
    </div>
    <div class="form-control quill-source-view" id="source-$this->replace->id" style="
    display:none;
    height: 300px;
    width: 100%;">
    </div>

</div>
<script>
    let idquill = '#$this->replace->id';
    let namequill = '#$this->replace->name';
    let toolbar = '#toolbar-$this->replace->id';
    let source = '#source-$this->replace->id';
    let endpointUpload = "{{TEMPLATE_URL}}{{#/posts/image/upload#}}";
    openquill(idquill, namequill, toolbar, source, endpointUpload)
</script>
