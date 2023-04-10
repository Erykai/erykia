<header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
    <div class="container-fluid px-4">
        <div class="page-header-content">
            <div class="row align-items-center justify-content-between pt-3">
                <div class="col-auto mb-3">
                    <h1 class="page-header-title">
                        <div class="page-header-icon"><i data-feather="example"></i></div>
                        {{Examples List}}
                    </h1>
                </div>
                <div class="col-12 col-xl-auto mb-3">
                    <a class="btn btn-sm btn-light text-primary"
                       href="{{TEMPLATE_URL}}{{#/dashboard/example-management-groups-list#}}">
                        <i class="me-1" data-feather="examples"></i>
                        {{Manage Groups}}
                    </a>
                    <a class="btn btn-sm btn-light text-primary"
                       href="{{TEMPLATE_URL}}{{#/dashboard/example-management-add-example#}}">
                        <i class="me-1" data-feather="example-plus"></i>
                        {{Add New Example}}
                    </a>
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
                    <th>{{Example}}</th>
                    <th>{{Email}}</th>
                    <th>{{Action}}</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
<script>
    //precisa passar a busca de usuarios pela examples e da view pela painel/examples
    createDataTable(
        "{{TEMPLATE_URL}}{{#/examples#}}",
        "{{TEMPLATE_URL}}{{#/dashboard/examples#}}",
        [
            "name",
            "email"
        ],
        "{{#/all#}}/0"
    )
</script>