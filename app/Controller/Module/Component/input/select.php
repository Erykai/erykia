<div class="mb-3">
    <label class="small mb-1" for="$this->replace->id">{{$this->replace->label}}</label>
    <select
        class="form-control select2-field"
        name="$this->replace->name"
        id="$this->replace->id"
        data-search-endpoint="{{#/$this->replace->route#}}"
        data-selected-id="{{ $this->replace->relation }}">
    </select>
</div>