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
    function handleRadioButtons(replaceId, replaceName, replaceValue) {
        let elementWithReplaceId = document.querySelector(`input[name="${replaceName}"][value="1"]`);
        let elementWithReplaceId2 = document.querySelector(`input[name="${replaceName}"][value="0"]`);

        if (replaceValue === "1") {
            elementWithReplaceId.checked = true;
        } else if (replaceValue === "0") {
            elementWithReplaceId2.checked = true;
        }
    }
    handleRadioButtons("$this->replace->id", "$this->replace->name", "{{ $this->replace->value }}");
</script>