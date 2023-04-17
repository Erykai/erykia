{{$this->replace->label}}
<div class="form-check form-check-solid">
    <input class="form-check-input" id="$this->replace->id" type="radio" name="$this->replace->name" value="1">
    <label class="form-check-label" for="$this->replace->id">{{Activated}}</label>
</div>
<div class="form-check form-check-solid">
    <input class="form-check-input" id="$this->replace->id2" type="radio" name="$this->replace->name" value="0">
    <label class="form-check-label" for="$this->replace->id2">{{Disabled}}</label>
</div>

<script>
    let $this->replace->id = document.querySelector(`input[name="$this->replace->name"][value="1"]`);
    let $this->replace->id2 = document.querySelector(`input[name="$this->replace->name"][value="0"]`);
    let $this->replace->name = "{{ $this->replace->value }}"

    if ( $this->replace->name === "1") {
        $this->replace->id.checked = true;
    } else if ( $this->replace->name === "0") {
        $this->replace->id2.checked = true;
    }
</script>