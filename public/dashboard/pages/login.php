<div class="container-xl px-4">
    <div class="row justify-content-center">
        <div class="col-lg-5">
            <!-- Basic login form-->
            <div class="card shadow-lg border-0 rounded-lg mt-5">
                <div class="card-header justify-content-center"><h3 class="fw-light my-4">{{Login}}</h3></div>
                <div class="card-body">
                    <!-- Login form-->
                    <form id="login-form" method="post">
                        <!-- Form Group (email address)-->
                        <div class="mb-3">
                            <label class="small mb-1" for="inputEmailAddress">{{Email}}</label>
                            <input class="form-control" id="inputEmailAddress" name="email" type="email" placeholder="{{Enter email address}}" />
                        </div>
                        <!-- Form Group (password)-->
                        <div class="mb-3">
                            <label class="small mb-1" for="inputPassword">{{Password}}</label>
                            <input class="form-control" id="inputPassword" name="password" type="password" placeholder="{{Enter password}}" />
                        </div>
                        <!-- Form Group (remember password checkbox)-->
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" id="rememberPasswordCheck" name="save" type="checkbox" value="" />
                                <label class="form-check-label" for="rememberPasswordCheck">{{Remember password}}</label>
                            </div>
                        </div>
                        <!-- Form Group (login box)-->
                        <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                            <a class="small" href="{{TEMPLATE_URL}}{{#/dashboard/forgot-password#}}">{{Forgot Password?}}</a>
                            <button class="btn btn-primary" type="submit">{{Login}}</button>
                        </div>
                    </form>
                </div>
                <div class="card-footer text-center">
                    <div class="small"><a href="{{TEMPLATE_URL}}{{#/dashboard/register#}}">{{Need an account? Sign up!}}</a></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    localStorage.removeItem('bearerErykia');
    const form = document.querySelector('#login-form');
    const emailInput = document.querySelector('#inputEmailAddress');
    const passwordInput = document.querySelector('#inputPassword');
    const rememberCheckbox = document.querySelector('#rememberPasswordCheck');
    const loginButton = document.querySelector('.btn-primary');

    let errorMessage = null;
    let successMessage = null;

    const saveLoginData = (email, password) => {
        const expirationDate = new Date();
        expirationDate.setFullYear(expirationDate.getFullYear() + 1);

        const loginData = { email, password, expirationDate };
        localStorage.setItem('loginData', JSON.stringify(loginData));
    }

    const getLoginData = () => {
        const loginData = localStorage.getItem('loginData');
        if (!loginData) {
            return null;
        }

        const { email, password, expirationDate } = JSON.parse(loginData);
        if (new Date(expirationDate) <= new Date()) {
            localStorage.removeItem('loginData');
            return null;
        }

        return { email, password };
    }

    const setLoginData = () => {
        const loginData = getLoginData();
        if (!loginData) {
            return;
        }

        emailInput.value = loginData.email;
        passwordInput.value = loginData.password;
        rememberCheckbox.checked = true;
    }

    setLoginData();

    form.addEventListener('submit', (event) => {
        event.preventDefault();

        // Desativando o botão de login
        loginButton.disabled = true;

        const email = emailInput.value;
        const password = passwordInput.value;

        // Salvando os dados de login, se o checkbox "Remember Me" estiver marcado
        if (rememberCheckbox.checked) {
            saveLoginData(email, password);
        } else {
            localStorage.removeItem('loginData');
        }

        fetch('{{TEMPLATE_URL}}{{#/login#}}', {
            method: 'POST',
            body: JSON.stringify({ email, password }),
            headers: {
                'Content-Type': 'application/json'
            },
            redirect: 'follow'
        })
            .then(response => response.json())
            .then(data => {
                // Remove a mensagem de erro ou sucesso anterior, se houver
                if (errorMessage) {
                    errorMessage.remove();
                    errorMessage = null;
                }
                if (successMessage) {
                    successMessage.remove();
                    successMessage = null;
                }

                if (data.type === 'error') {
                    // Exibindo mensagem de erro
                    errorMessage = document.createElement('p');
                    errorMessage.innerText = data.text;
                    errorMessage.classList.add('text-danger');
                    form.appendChild(errorMessage);

                    // Ativando o botão de login
                    loginButton.disabled = false;
                } else if (data.type === 'success') {
                    // Exibindo mensagem de sucesso
                    successMessage = document.createElement('p');
                    successMessage.innerText = '{{Login successful! Redirecting...}}';
                    successMessage.classList.add('text-success');
                    form.appendChild(successMessage);
                    localStorage.setItem('bearerErykia', data.text);
                    // Aguardando 3 segundos antes de atualizar a página
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                }
            })
            .catch(error => {
                // Exibindo mensagem de erro genérica
                errorMessage = document.createElement('p');
                errorMessage.innerText = '{{Failed to login. Please try again later.}}';
                errorMessage.classList.add('text-danger');
                form.appendChild(errorMessage);

                // Ativando o botão de login
                loginButton.disabled = false;
            });
    });
</script>