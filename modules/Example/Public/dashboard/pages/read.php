<!-- Main page content-->
<div class="container-xl px-4 mt-4">
    <!-- Account page navigation-->
    <nav class="nav nav-borders">
        <a class="nav-link active ms-0" href="#">{{Example}}</a>
    </nav>
    <hr class="mt-0 mb-4"/>
    <div class="row">
        <div class="col-xl-4" id="colFour">
            <!-- Profile picture card-->
            <div class="card mb-4 mb-xl-0">
                <div class="card-header">{{Example}}</div>
                <div class="card-body text-center">
                    /*#store-output-4#*/
                </div>
            </div>
        </div>
        <div class="col">
            <!-- Account details card-->
            <div class="card mb-4">
                <div class="card-header">
                    {{Details}} <div id="return-msg"></div>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        /*#read-li#*/
                    </ul>

                </div>
                <div class="card-footer">
                    <a href="{{TEMPLATE_URL}}{{#/dashboard/examples/edit#}}/{{ $this->example->id }}"
                       class="btn btn-blue" title="{{Edit}}">
                        <i class="fas fa-edit"></i>
                    </a>
                    <a href="#"
                       id="trashBtn"
                       class="btn btn-danger"
                       title="{{Destroy}}"
                       onclick="handleDeleteBtnClick(event, '{{TEMPLATE_URL}}{{#/examples#}}/{{ $this->example->id }}', 1)">
                        <i class="fas fa-trash"></i>
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
            trashBtn.setAttribute('onclick', `handleDeleteBtnClick(event, '{{TEMPLATE_URL}}{{#/examples#}}/{{ $this->example->id }}', 1)`);
            trashBtn.innerHTML = trashIcon.outerHTML + ' {{Move Trash}}';
        } else if (trashValue === '1') {
            localLabelElement.textContent = "Lixeira";
            trashBtn.classList.remove('btn-danger');
            trashBtn.classList.add('btn-success'); // Mudar a cor do botão para verde
            trashIcon.classList.remove('fa-trash');
            trashIcon.classList.add('fa-undo');
            trashBtn.setAttribute('onclick', `handleDeleteBtnClick(event, '{{TEMPLATE_URL}}{{#/examples#}}/{{ $this->example->id }}', 0)`);
            trashBtn.innerHTML = trashIcon.outerHTML + ' {{Restore Trash}}'; // Atualizar o texto do botão
        } else {
            localLabelElement.textContent = "Valor inválido";
        }
    }
    const uploadButton = document.querySelector('#uploadImage');
    if (!uploadButton) {
        document.querySelector('#colFour').remove();
    }
    // document.querySelector('#colFour').remove();
    document.addEventListener('DOMContentLoaded', function() {
        updatePageElements('{{ $this->example->trash }}');
    });

</script>