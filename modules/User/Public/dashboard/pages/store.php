<header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
    <div class="container-xl px-4">
        <div class="page-header-content">
            <div class="row align-items-center justify-content-between pt-3">
                <div class="col-auto mb-3">
                    <h1 class="page-header-title">
                        <div class="page-header-icon"><i data-feather="user"></i></div>
                        {{Add User}} - {{User}}
                    </h1>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- Main page content-->
<div class="container-xl px-4 mt-4">
    <!-- Account page navigation-->
    <nav class="nav nav-borders">
        <a class="nav-link active ms-0" href="#">{{User}}</a>
    </nav>
    <hr class="mt-0 mb-4"/>
    <div class="row">
        <div class="col-xl-4" id="colFour">

            <!-- Profile picture card-->
            <div class="card mb-4 mb-xl-0">
                <div class="card-header">{{User}}</div>
                <div class="card-body text-center">
                    <label class="small mb-1 d-block" for="UserCover">{{Cover}}</label>
<!-- Profile picture image-->
<img id="UserCover"
     class="img-account-profile mb-2"
     src="{{TEMPLATE_URL}}/{{ $this->user->cover }}"
     alt=""/>
<!-- Profile picture help block-->
<div class="small font-italic text-muted mb-4">{{JPG or PNG no larger than 5 MB}}</div>
<!-- Profile picture upload button-->
<button id="uploadImage" class="btn btn-primary" type="button">{{Upload new image}}</button>


                </div>
            </div>
        </div>
        <div class="col">
            <!-- Account details card-->
            <div class="card mb-4">
                <div class="card-header">{{Details}}</div>
                <div class="card-body">
                    <form method="post" id="myForm">
                        <!-- Form Group (username)-->
                        <div class="mb-3">
    <label class="small mb-1" for="UserName">{{Name}}</label>
    <input
        name="name"
        class="form-control"
        id="UserName"
        type="text"
        placeholder="{{Name}}"
        value="{{ $this->user->name }}"
    />
</div>
<div class="mb-3">
    <label class="small mb-1" for="UserEmail">{{Email}}</label>
    <input
        name="email"
        class="form-control"
        id="UserEmail"
        type="text"
        placeholder="{{Email}}"
        value="{{ $this->user->email }}"
    />
</div>
<div class="mb-3 position-relative">
    <label class="small mb-1" for="UserPassword">{{Password}}</label>
    <div class="input-group input-group-joined">
        <input
                name="password"
                class="form-control"
                id="UserPassword"
                type="password"
                placeholder="{{Password}}"
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
        const passwordInput = document.getElementById('UserPassword');
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

</script><div class="mb-3">
    <label class="small mb-1" for="UserLevel">{{Level}}</label>
    <input
        name="level"
        class="form-control"
        id="UserLevel"
        type="text"
        placeholder="{{Level}}"
        value="{{ $this->user->level }}"
    />
</div>

                        <input type="hidden" name="trash" value="0">
                        <button class="btn btn-primary" type="submit">{{Save}}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    const form = document.querySelector('#myForm');
    const submitButton = form.querySelector('button[type="submit"]');


    // Function to handle image upload
    function handleImageUpload(event) {
        const input = event.target;
        const reader = new FileReader();
        reader.onloadend = () => {
            const img = document.querySelector('.img-account-profile');
            img.src = reader.result;
            form.coverImage = input.files[0];
        };
        reader.readAsDataURL(input.files[0]);
    }

    // Add event listener to "Upload new image" button
    const uploadButton = document.querySelector('#uploadImage');
    if (uploadButton) {
        const fileInput = document.createElement('input');
        fileInput.type = 'file';
        fileInput.accept = 'image/png, image/jpeg';
        fileInput.style.display = 'none';
        fileInput.addEventListener('change', handleImageUpload);
        document.body.appendChild(fileInput);

        uploadButton.addEventListener('click', () => {
            fileInput.click();
        });
    }else{
        document.querySelector('#colFour').remove();
    }

    // Create the div element to display the return message
    const messageElement = document.createElement('div');
    messageElement.setAttribute('id', 'message');
    form.appendChild(messageElement);

    form.addEventListener('submit', (event) => {
        event.preventDefault();
        submitButton.disabled = true;
        if (typeof globalQuill !== 'undefined') {
            form.querySelector(`input[name="${namequill}"]`).value = globalQuill.root.innerHTML;
            const hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'description';
            form.appendChild(hiddenInput);
        }
        const formData = new FormData(form);

        if (form.coverImage) {
            formData.append('cover', form.coverImage, form.coverImage.name);
        }

        fetch('{{TEMPLATE_URL}}{{#/users#}}', {
            method: 'POST',
            body: formData,
            headers: {
                'Accept-Language': 'pt-BR',
                'Authorization': `Bearer ${bearerErykia}`
            },
            redirect: 'follow'
        })
            .then(response => response.json())
            .then(data => {
                submitButton.disabled = false;
                messageElement.textContent = data.text;

                if (data.type === 'success') {
                    messageElement.style.color = 'green';
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                } else {
                    messageElement.style.color = 'red';
                }
            })
            .catch(error => {
                submitButton.disabled = false;
                alert("error");
            });
    });
</script>
<script>
    const select2Translations = {
        "{{LANG}}": {
            errorLoading: function () {
                return '{{Results could not be loaded}}.';
            },
            inputTooLong: function (args) {
                const overChars = args.input.length - args.maximum;
                return '{{Erase}} ' + overChars + ' {{characters}}';
            },
            inputTooShort: function (args) {
                const remainingChars = args.minimum - args.input.length;
                return '{{Enter}} ' + remainingChars + ' {{or more characters}}';
            },
            loadingMore: function () {
                return '{{Loading more results}}...';
            },
            noResults: function () {
                return '{{No results found}}';
            },
            searching: function () {
                return '{{Seeking out}}...';
            },
            removeAllItems: function () {
                return '{{Remove all items}}';
            }
        }
    };
</script>
<script>
    $(".select2-field").each(function () {
        const $this = $(this);

        // Use data attributes para armazenar informações específicas para cada campo
        const searchEndpoint = $this.data("search-endpoint");

        $this.select2({
            width: "100%",
            language: select2Translations["{{LANG}}"],
            placeholder: "{{Type to search}}",
            minimumInputLength: 3,
            theme: "bootstrap4",
            ajax: {
                url: function (params) {
                    return `{{TEMPLATE_URL}}${searchEndpoint}?search=[nameLIKE%${params.term}%]`;
                },
                dataType: "json",
                headers: {
                    Authorization: "Bearer " + bearerErykia
                },
                processResults: function (data) {
                    return {
                        results: data.data.map(item => ({
                            id: item.id,
                            text: item.name
                        }))
                    };
                }
            }
        });
    });
</script>