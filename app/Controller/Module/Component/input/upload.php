<label class="small mb-1 d-block" for="$this->replace->id">{{$this->replace->label}}</label>
<!-- Profile picture image-->
<img id="$this->replace->id"
     class="img-account-profile mb-2"
     src="{{TEMPLATE_URL}}/{{ $this->replace->value }}"
     alt=""/>
<!-- Profile picture help block-->
<div class="small font-italic text-muted mb-4">{{JPG or PNG no larger than 5 MB}}</div>
<!-- Profile picture upload button-->
<button id="uploadImage" class="btn btn-primary" type="button">{{Upload new image}}</button>

