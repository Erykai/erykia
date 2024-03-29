<header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
    <div class="container-xl px-4">
        <div class="page-header-content">
            <div class="row align-items-center justify-content-between pt-3">
                <div class="col-auto mb-3">
                    <h1 class="page-header-title">
                        <div class="page-header-icon"><i data-feather="user"></i></div>
                        {{Account Settings}} - {{Profile}}
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
        <a class="nav-link active ms-0" href="account-profile.html">{{Profile}}</a>
    </nav>
    <hr class="mt-0 mb-4"/>
    <div class="row">
        <div class="col-xl-4">
            <!-- Profile picture card-->
            <div class="card mb-4 mb-xl-0">
                <div class="card-header">{{Profile Picture}}</div>
                <div class="card-body text-center">
                    <!-- Profile picture image-->
                    <img class="img-account-profile rounded-circle mb-2"
                         src="{{TEMPLATE_URL}}/{{ $this->login->cover }}"
                         alt=""/>
                    <!-- Profile picture help block-->
                    <div class="small font-italic text-muted mb-4">{{JPG or PNG no larger than 5 MB}}</div>
                    <!-- Profile picture upload button-->
                    <button class="btn btn-primary" type="button">{{Upload new image}}</button>
                </div>
            </div>
        </div>
        <div class="col-xl-8">
            <!-- Account details card-->
            <div class="card mb-4">
                <div class="card-header">{{Account Details}}</div>
                <div class="card-body">
                    <form method="post" id="myForm">
                        <!-- Form Group (username)-->
                        <div class="mb-3">
                            <label class="small mb-1" for="inputUsername">
                                {{Username (how your name will appear to other users on the site)}}
                            </label>
                            <input name="name" class="form-control" id="inputUsername" type="text"
                                   placeholder="{{Enter your name}}" value="{{ $this->login->name }}"/>
                        </div>

                        <div class="mb-3">
                            <label class="small mb-1" for="inputCurrentPassword">{{Password}}</label>
                            <input name="password" class="form-control" id="inputCurrentPassword" type="password"
                                   placeholder="{{Enter a password to change the current one}}"/>
                        </div>

                        <div class="mb-3">
                            <label class="small mb-1" for="inputEmailAddress">{{Email address}}</label>
                            <input name="email" class="form-control" id="inputEmailAddress" type="email"
                                   placeholder="Enter your email address" value="{{ $this->login->email }}"/>
                        </div>
                        <button class="btn btn-primary" type="submit">{{Save changes}}</button>
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
    const uploadButton = document.querySelector('.btn.btn-primary');
    const fileInput = document.createElement('input');
    fileInput.type = 'file';
    fileInput.accept = 'image/png, image/jpeg';
    fileInput.style.display = 'none';
    fileInput.addEventListener('change', handleImageUpload);
    document.body.appendChild(fileInput);

    uploadButton.addEventListener('click', () => {
        fileInput.click();
    });

    // Create the div element to display the return message
    const messageElement = document.createElement('div');
    messageElement.setAttribute('id', 'message');
    form.appendChild(messageElement);

    form.addEventListener('submit', (event) => {
        event.preventDefault();
        submitButton.disabled = true;
        const formData = new FormData(form);

        if (form.coverImage) {
            formData.append('cover', form.coverImage, form.coverImage.name);
        }

        fetch('{{TEMPLATE_URL}}{{#/users#}}/{{ $this->login->id }}', {
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

