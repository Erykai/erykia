<!DOCTYPE html>
<html lang="{{LANG}}">
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <meta name="description" content=""/>
    <meta name="author" content=""/>
    <title>{{Dashboard}} - Erykia</title>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css"/>
    <link rel="stylesheet" type="text/css"
          href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
    <link href="https://cdn.jsdelivr.net/npm/litepicker/dist/css/litepicker.css" rel="stylesheet"/>
    <link href="{{TEMPLATE_URL}}/public/{{TEMPLATE_DASHBOARD}}/assets/css/styles.css" rel="stylesheet"/>
    <link rel="icon" type="image/x-icon" href="{{TEMPLATE_URL}}/public/{{TEMPLATE_DASHBOARD}}/assets/img/favicon.png"/>
    <script data-search-pseudo-elements defer
            src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/js/all.min.js"
            crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.28.0/feather.min.js"
            crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
            crossorigin="anonymous"></script>
    <script src="{{TEMPLATE_URL}}/public/{{TEMPLATE_DASHBOARD}}/assets/js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js" crossorigin="anonymous"></script>
    <!--    <script src="{{TEMPLATE_URL}}/public/{{TEMPLATE_DASHBOARD}}/assets/demo/chart-area-demo.js"></script>-->
    <!--    <script src="{{TEMPLATE_URL}}/public/{{TEMPLATE_DASHBOARD}}/assets/demo/chart-bar-demo.js"></script>-->
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/litepicker/dist/bundle.js" crossorigin="anonymous"></script>
    <script src="{{TEMPLATE_URL}}/public/{{TEMPLATE_DASHBOARD}}/assets/js/litepicker.js"></script>
    <script>
        const bearerErykia = localStorage.getItem('bearerErykia');

        async function handleDeleteBtnClick(event, endpoint, newTrashValue) {
            event.preventDefault();

            const response = await fetch(endpoint, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': 'Bearer ' + bearerErykia
                },
                body: JSON.stringify({ trash: newTrashValue })
            });

            const result = await response.json();
            displayMessage(result.text, result.type);
        }
        async function handlePermanentDeleteBtnClick(event, endpoint) {
            event.preventDefault();

            const response = await fetch(endpoint, {
                method: 'DELETE',
                headers: {
                    'Authorization': 'Bearer ' + bearerErykia
                }
            });

            const result = await response.json();
            displayMessage(result.text, result.type);
        }

        function capitalizeFirstLetter(string) {
            return string.charAt(0).toUpperCase() + string.slice(1);
        }

        function displayMessage(message, messageType) {
            const returnMsgElement = document.querySelector('#return-msg');
            returnMsgElement.textContent = capitalizeFirstLetter(message);
            returnMsgElement.style.color = messageType === 'error' ? 'red' : 'green';

            if (messageType === 'success') {
                setTimeout(() => {
                    window.location.reload();
                }, 1000);
            }
        }

        function createDataTable(endpoint, endpointAction, columnNames, trash) {
            const columns = columnNames.map(name => {
                return {"data": name, "searchable": true};
            });

            document.addEventListener('DOMContentLoaded', function () {
                let table = new DataTable(document.querySelector('#datatables'), {
                    scrollX: '100%',
                    dom: 'Bfrtip',
                    buttons: [
                        {
                            extend: 'copy',
                            text: '{{COPY}}',
                            exportOptions: {
                                columns: ':visible'
                            }
                        },
                        {
                            extend: 'csv',
                            text: 'CSV',
                            exportOptions: {
                                columns: ':visible'
                            }
                        },
                        {
                            extend: 'excel',
                            text: 'EXCEL',
                            exportOptions: {
                                columns: ':visible'
                            }
                        },
                        {
                            extend: 'pdf',
                            text: 'PDF',
                            exportOptions: {
                                columns: ':visible'
                            }
                        },
                        {
                            extend: 'print',
                            text: '{{PRINT}}',
                            exportOptions: {
                                columns: ':visible'
                            }
                        }
                    ],
                    "ajax": {
                        "url": endpoint + trash,
                        "headers": {
                            "Authorization": "Bearer " + bearerErykia
                        },
                        "dataSrc": "data",
                        "data": function (d) {
                            d.start = d.start || 0;
                            d.length = d.length || 10;
                        },
                        "dataFilter": function (response) {
                            let json = JSON.parse(response);
                            json.recordsTotal = json.all || 0;
                            json.recordsFiltered = json.all || 0;
                            return JSON.stringify(json);
                        }
                    },
                    "columns": columns.concat({
                        "title": "{{Action}}",
                        "data": null,
                        "render": function (data, type, row, meta) {
                            let editBtn = trash.endsWith('1') ? '' : `<a href="${endpointAction}{{#/edit#}}/${row.id}" class="edit-btn" title="{{Edit}}"><i class="fas fa-edit"></i></a>`;
                            let deleteIcon = trash.endsWith('1') ? 'fas fa-undo' : 'fas fa-trash';
                            let deleteBtnColor = trash.endsWith('1') ? 'style="color: green;"' : '';
                            let newTrashValue = trash.endsWith('1') ? '0' : '1';
                            let deleteBtn = `<a href="#" class="delete-btn" title="{{Destroy}}" ${deleteBtnColor} onclick="handleDeleteBtnClick(event, '${endpoint}/${row.id}', '${newTrashValue}')"><i class="${deleteIcon}"></i></a>`;

                            let permanentDeleteBtn = '';
                            if (trash.endsWith('1')) {
                                permanentDeleteBtn = `<a href="#" class="permanent-delete-btn" style="color: red;" title="{{Permanent Delete}}" onclick="handlePermanentDeleteBtnClick(event, '${endpoint}/${row.id}')"><i class="fas fa-times"></i></a>`;
                            }

                            return editBtn + " " + deleteBtn + " " + permanentDeleteBtn;
                        },
                        "orderable": false,
                        "searchable": false
                    }),
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
                table.on('preXhr.dt', function (e, settings, data) {
                    let searchInput = document.querySelector('input[type="search"]');
                    if (searchInput) {
                        data.search = searchInput.value;
                    }
                });
            });
        }
    </script>
</head>
<body class="nav-fixed">
<nav class="topnav navbar navbar-expand shadow justify-content-between justify-content-sm-start navbar-light bg-white"
     id="sidenavAccordion">
    <!-- Sidenav Toggle Button-->
    <button class="btn btn-icon btn-transparent-dark order-1 order-lg-0 me-2 ms-lg-2 me-lg-0" id="sidebarToggle"><i
                data-feather="menu"></i></button>
    <!-- Navbar Brand-->
    <!-- * * Tip * * You can use text or an image for your navbar brand.-->
    <!-- * * * * * * When using an image, we recommend the SVG format.-->
    <!-- * * * * * * Dimensions: Maximum height: 32px, maximum width: 240px-->
    <a class="navbar-brand pe-3 ps-4 ps-lg-2" href="{{TEMPLATE_URL}}{{#/dashboard#}}">Erykia Admin</a>

    <ul class="navbar-nav align-items-center ms-auto">
        <!-- User Dropdown-->
        <li class="nav-item dropdown no-caret dropdown-user me-3 me-lg-4">
            <a class="btn btn-icon btn-transparent-dark dropdown-toggle" id="navbarDropdownUserImage"
               href="javascript:void(0);" role="button" data-bs-toggle="dropdown" aria-haspopup="true"
               aria-expanded="false"><img class="img-fluid" src="{{TEMPLATE_URL}}/{{ $this->login->cover }}"/></a>
            <div class="dropdown-menu dropdown-menu-end border-0 shadow animated--fade-in-up"
                 aria-labelledby="navbarDropdownUserImage">
                <h6 class="dropdown-header d-flex align-items-center">
                    <img class="dropdown-user-img" src="{{TEMPLATE_URL}}/{{ $this->login->cover }}"/>
                    <div class="dropdown-user-details">
                        <div class="dropdown-user-details-name">{{ $this->login->name }}</div>
                        <div class="dropdown-user-details-email">{{ $this->login->email }}</div>
                    </div>
                </h6>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="{{TEMPLATE_URL}}{{#/dashboard/account-profile#}}">
                    <div class="dropdown-item-icon"><i data-feather="settings"></i></div>
                    {{Account}}
                </a>
                <a class="dropdown-item" href="#" id="logout">
                    <div class="dropdown-item-icon"><i data-feather="log-out"></i></div>
                    {{Logout}}
                </a>
            </div>
        </li>
    </ul>
</nav>
<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <nav class="sidenav shadow-right sidenav-light">
            <div class="sidenav-menu">
                <div class="nav accordion" id="accordionSidenav">
                    <!-- Sidenav Menu Heading (Account)-->
                    <!-- * * Note: * * Visible only on and above the sm breakpoint-->
                    <div class="sidenav-menu-heading d-sm-none">{{Account}}</div>
                    <!-- Sidenav Link (Alerts)-->
                    <!-- * * Note: * * Visible only on and above the sm breakpoint-->
                    <a class="nav-link d-sm-none" href="#!">
                        <div class="nav-link-icon"><i data-feather="bell"></i></div>
                        {{Alerts}}
                        <span class="badge bg-warning-soft text-warning ms-auto">{{4 New!}}</span>
                    </a>
                    <!-- Sidenav Link (Messages)-->
                    <!-- * * Note: * * Visible only on and above the sm breakpoint-->
                    <a class="nav-link d-sm-none" href="#!">
                        <div class="nav-link-icon"><i data-feather="mail"></i></div>
                        {{Messages}}
                        <span class="badge bg-success-soft text-success ms-auto">{{2 New!}}</span>
                    </a>
                    <!-- Sidenav Menu Heading (Core)-->
                    <div class="sidenav-menu-heading">{{Core}}</div>
                    <!-- Sidenav Accordion (Dashboard)-->
                    <a class="nav-link" href="{{TEMPLATE_URL}}{{#/dashboard#}}">
                        <div class="nav-link-icon"><i data-feather="activity"></i></div>
                        {{Dashboard}}
                    </a>
                    <!-- Sidenav Heading (Custom)-->
                    <div class="sidenav-menu-heading">{{User Management}}</div>
                    <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse"
                       data-bs-target="#appsCollapseUserManagement" aria-expanded="false"
                       aria-controls="appsCollapseUserManagement">
                        <div class="nav-link-icon"><i data-feather="users"></i></div>
                        {{Users}}
                        <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="appsCollapseUserManagement"
                         data-bs-parent="#accordionSidenavAppsMenu">
                        <nav class="sidenav-menu-nested nav">
                            <a class="nav-link" href="{{TEMPLATE_URL}}{{#/dashboard/users/all#}}">{{Users List}}</a>
                            <a class="nav-link" href="{{TEMPLATE_URL}}{{#/dashboard/users/store#}}">{{Add User}}</a>
                            <a class="nav-link" href="{{TEMPLATE_URL}}{{#/dashboard/users/trash#}}">{{Trash}}</a>
                        </nav>
                    </div>

                </div>
            </div>
            <!-- Sidenav Footer-->
            <div class="sidenav-footer">
                <div class="sidenav-footer-content">
                    <div class="sidenav-footer-subtitle">{{Logged in as}}:</div>
                    <div class="sidenav-footer-title">{{ $this->login->name }}</div>
                </div>
            </div>
        </nav>
    </div>
    <div id="layoutSidenav_content">
        <main>
            {{PAGE}}
        </main>
        <footer class="footer-admin mt-auto footer-light">
            <div class="container-xl px-4">
                <div class="row">
                    <div class="col-md-6 small">{{Copyright}} &copy; Erykia 2023</div>
                    <div class="col-md-6 text-md-end small">
                        <a href="#!">{{Privacy Policy}}</a>
                        &middot;
                        <a href="#!">{{Terms}} &amp; {{Conditions}}</a>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</div>
<script>
    const logoutLink = document.querySelector('#logout');
    logoutLink.addEventListener('click', (event) => {
        event.preventDefault();

        fetch('{{TEMPLATE_URL}}{{#/logout#}}', {
            method: 'POST',
            headers: {
                'Accept-Language': 'pt-BR',
                'Authorization': `Bearer ${bearerErykia}`
            },
            redirect: 'follow'
        })
            .then(response => response.json())
            .then(data => {
                if (data.type === 'success') {
                    window.location.href = '{{TEMPLATE_URL}}{{#/dashboard#}}';
                }
            })
            .catch(error => {
                alert("error");
            });
    });
</script>
</body>
</html>
