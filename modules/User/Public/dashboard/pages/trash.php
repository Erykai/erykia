<header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
    <div class="container-fluid px-4">
        <div class="page-header-content">
            <div class="row align-items-center justify-content-between pt-3">
                <div class="col-auto mb-3">
                    <h1 class="page-header-title">
                        <div class="page-header-icon"><i data-feather="user"></i></div>
                        {{List of users in the trash}}
                    </h1>
                    <p></p>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- Main page content-->
<div class="container-fluid px-4">
    <div class="card">
        <div class="card-header">
            <div id="return-msg"></div>
        </div>
        <div class="card-body">
            <table id="datatables">
                <thead>
                <tr>
                    <th>{{User}}</th>
                    <th>{{Email}}</th>
                    <th>{{Action}}</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
<script>
    //precisa passar a busca de usuarios pela users e da view pela painel/users
    createDataTable(
        "{{TEMPLATE_URL}}{{#/users#}}",
        "{{TEMPLATE_URL}}{{#/dashboard/users#}}",
        [
            "name",
            "email"
        ],
        "{{#/all#}}/1"
    )
</script>