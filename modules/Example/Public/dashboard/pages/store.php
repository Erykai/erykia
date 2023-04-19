<header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
    <div class="container-xl px-4">
        <div class="page-header-content">
            <div class="row align-items-center justify-content-between pt-3">
                <div class="col-auto mb-3">
                    <h1 class="page-header-title">
                        <div class="page-header-icon"><i data-feather="example"></i></div>
                        {{Add Example}} - {{Example}}
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
        <a class="nav-link active ms-0" href="#">{{Example}}</a>
    </nav>
    <hr class="mt-0 mb-4"/>
    <div class="row">
        <div class="col-xl-4">
            <!-- Profile picture card-->
            <div class="card mb-4 mb-xl-0">
                <div class="card-header">{{Example Picture}}</div>
                <div class="card-body text-center">
                    <!-- Profile picture image-->
                    <img class="img-account-profile rounded-circle mb-2"
                         src="{{TEMPLATE_URL}}/public/{{TEMPLATE_DASHBOARD}}/assets/img/illustrations/profiles/profile-1.png"
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
                <div class="card-header">{{Example Details}}</div>
                <div class="card-body">
                    <form method="post" id="myForm">
                        <!-- Form Group (examplename)-->
                        /*#store-input#*/
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
        let fieldName = quill.options.name;
        formData.set(fieldName, quill.root.innerHTML);
        if (form.coverImage) {
            formData.append('cover', form.coverImage, form.coverImage.name);
        }

        fetch('{{TEMPLATE_URL}}{{#/examples#}}', {
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
    $(".select2-field").each(function() {
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
                url: function(params) {
                    return `{{TEMPLATE_URL}}${searchEndpoint}?search=[nameLIKE%${params.term}%]`;
                },
                dataType: "json",
                headers: {
                    Authorization: "Bearer " + bearerErykia
                },
                processResults: function(data) {
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