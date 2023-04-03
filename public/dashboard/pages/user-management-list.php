<header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
    <div class="container-fluid px-4">
        <div class="page-header-content">
            <div class="row align-items-center justify-content-between pt-3">
                <div class="col-auto mb-3">
                    <h1 class="page-header-title">
                        <div class="page-header-icon"><i data-feather="user"></i></div>
                        {{Users List}}
                    </h1>
                </div>
                <div class="col-12 col-xl-auto mb-3">
                    <a class="btn btn-sm btn-light text-primary"
                       href="{{TEMPLATE_URL}}{{#/dashboard/user-management-groups-list#}}">
                        <i class="me-1" data-feather="users"></i>
                        {{Manage Groups}}
                    </a>
                    <a class="btn btn-sm btn-light text-primary"
                       href="{{TEMPLATE_URL}}{{#/dashboard/user-management-add-user#}}">
                        <i class="me-1" data-feather="user-plus"></i>
                        {{Add New User}}
                    </a>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- Main page content-->
<div class="container-fluid px-4">
    <div class="card">
        <div class="card-body">
            <table id="datatables">
                <thead>
                <tr>
                    <th>{{User}}</th>
                    <th>{{Email}}</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        let table = new DataTable(document.querySelector('#datatables'), {
            "ajax": {
                "url": "{{TEMPLATE_URL}}{{#/users#}}",
                "dataSrc": "data",
                "data": function(d) {
                    d.start = d.start || 0;
                    d.length = d.length || 10;
                },
                "dataFilter": function(response) {
                    let json = JSON.parse(response);
                    json.recordsTotal = json.all || 0;
                    json.recordsFiltered = json.all || 0;
                    return JSON.stringify(json);
                }
            },
            "columns": [
                {
                    "data": "name",
                    "searchable": true
                },
                {
                    "data": "email",
                    "searchable": true
                }
            ],
            "paging": true,
            "pageLength": 10,
            "searching": true,
            "serverSide": true,
            "language": {
                "emptyTable": "{{No results found}}",
                "info": "{{Showing}} _START_ {{to}} _END_ {{of}} _TOTAL_ {{entries}}",
                "infoEmpty": "{{Showing 0 to 0 of 0 entries}}",
                "infoFiltered": "({{filtered from}} _MAX_ {{total entries}})",
                "lengthMenu": "{{Show}} _MENU_ {{entries}}",
                "loadingRecords": "{{Loading...}}",
                "processing": "{{Processing...}}",
                "search": "{{Search}}:",
                "zeroRecords": "{{No matching records found}}",
                "paginate": {
                    "first": "{{First}}",
                    "last": "{{Last}}",
                    "next": "{{Next}}",
                    "previous": "{{Previous}}"
                },
                "aria": {
                    "sortAscending": ": {{activate to sort column ascending}}",
                    "sortDescending": ": {{activate to sort column descending}}"
                }
            }
        });

        // Add this event handler to update the search value before each AJAX request
        table.on('preXhr.dt', function(e, settings, data) {
            let searchInput = document.querySelector('input[type="search"]');
            if (searchInput) {
                data.search = searchInput.value;
            }
        });
    });

</script>