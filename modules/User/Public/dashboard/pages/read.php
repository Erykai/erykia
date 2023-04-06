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
        <a class="nav-link active ms-0" href="#">{{Profile}}</a>
    </nav>
    <hr class="mt-0 mb-4"/>
    <div class="row">
        <div class="col-xl-4">
            <!-- Profile picture card-->
            <div class="card mb-4 mb-xl-0">
                <div class="card-header">{{Photo}}</div>
                <div class="card-body text-center">
                    <!-- Profile picture image-->
                    <img class="img-account-profile rounded-circle mb-2"
                         src="{{TEMPLATE_URL}}/{{ $this->user->cover }}"
                         alt=""/>
                </div>
            </div>
        </div>
        <div class="col-xl-8">
            <!-- Account details card-->
            <div class="card mb-4">
                <div class="card-header">
                    {{Details}} <div id="return-msg"></div>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <b>{{Name}}:</b> {{ $this->user->name }}
                        </li>
                        <li class="list-group-item">
                            <b>{{Email}}:</b> {{ $this->user->email }}
                        </li>
                        <li class="list-group-item">
                            <b>{{Local}}:</b> <span id="localLabel"></span>
                        </li>
                    </ul>

                </div>
                <div class="card-footer">
                    <a href="{{TEMPLATE_URL}}{{#/dashboard/users/edit#}}/{{ $this->user->id }}"
                       class="btn btn-blue" title="{{Edit}}">
                        <i class="fas fa-edit"></i> {{Edit}}
                    </a>
                    <a href="#"
                       id="trashBtn"
                       class="btn btn-danger"
                       title="{{Destroy}}"
                       onclick="handleDeleteBtnClick(event, '{{TEMPLATE_URL}}{{#/users#}}/{{ $this->user->id }}', 1)">
                        <i class="fas fa-trash"></i> {{Move Trash}}
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function updatePageElements(trashValue) {
        const localLabelElement = document.getElementById('localLabel');
        const trashBtn = document.getElementById('trashBtn');
        const trashIcon = trashBtn.querySelector('i');

        if (trashValue === '0') {
            localLabelElement.textContent = "Caixa de Entrada";
            trashBtn.classList.remove('btn-success');
            trashBtn.classList.add('btn-danger');
            trashIcon.classList.remove('fa-undo');
            trashIcon.classList.add('fa-trash');
            trashBtn.setAttribute('onclick', `handleDeleteBtnClick(event, '{{TEMPLATE_URL}}{{#/users#}}/{{ $this->user->id }}', 1)`);
            trashBtn.innerHTML = trashIcon.outerHTML + ' {{Move Trash}}';
        } else if (trashValue === '1') {
            localLabelElement.textContent = "Lixeira";
            trashBtn.classList.remove('btn-danger');
            trashBtn.classList.add('btn-success'); // Mudar a cor do botão para verde
            trashIcon.classList.remove('fa-trash');
            trashIcon.classList.add('fa-undo');
            trashBtn.setAttribute('onclick', `handleDeleteBtnClick(event, '{{TEMPLATE_URL}}{{#/users#}}/{{ $this->user->id }}', 0)`);
            trashBtn.innerHTML = trashIcon.outerHTML + ' {{Restore Trash}}'; // Atualizar o texto do botão
        } else {
            localLabelElement.textContent = "Valor inválido";
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        updatePageElements('{{ $this->user->trash }}');
    });

</script>