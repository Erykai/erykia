<div class="mb-3 position-relative">
    <label class="small mb-1" for="$this->replace->id">{{$this->replace->label}}</label>
    <div class="input-group input-group-joined">
        <input
                name="$this->replace->name"
                class="form-control"
                id="$this->replace->id"
                type="password"
                placeholder="{{$this->replace->label}}"
                value=""
        />
        <span class="toggle-password input-group-text">
        <i class="fas fa-eye"></i>
    </span>
    </div>
</div>

<!-- Joined input group append example-->


<script>
    document.querySelector('.toggle-password').addEventListener('click', function () {
        const passwordInput = document.getElementById('$this->replace->id');
        const passwordIcon = this.querySelector('.fas');

        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            passwordIcon.classList.remove('fa-eye');
            passwordIcon.classList.add('fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            passwordIcon.classList.remove('fa-eye-slash');
            passwordIcon.classList.add('fa-eye');
        }
    });

</script>