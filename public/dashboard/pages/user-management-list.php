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
                    <a class="btn btn-sm btn-light text-primary" href="{{TEMPLATE_URL}}{{#/dashboard/user-management-groups-list#}}">
                        <i class="me-1" data-feather="users"></i>
                        {{Manage Groups}}
                    </a>
                    <a class="btn btn-sm btn-light text-primary" href="{{TEMPLATE_URL}}{{#/dashboard/user-management-add-user#}}">
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
            <table id="datatablesSimple">
                <thead>
                <tr>
                    <th>{{User}}</th>
                    <th>{{Email}}</th>
                    <th>{{Role}}</th>
                    <th>{{Groups}}</th>
                    <th>{{Joined Date}}</th>
                    <th>{{Actions}}</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>{{User}}</th>
                    <th>{{Email}}</th>
                    <th>{{Role}}</th>
                    <th>{{Groups}}</th>
                    <th>{{Joined Date}}</th>
                    <th>{{Actions}}</th>
                </tr>
                </tfoot>
                <tbody>
                <tr>
                    <td>
                        <div class="d-flex align-items-center">
                            <div class="avatar me-2"><img class="avatar-img img-fluid" src="{{TEMPLATE_URL}}/public/{{TEMPLATE_DASHBOARD}}/assets/img/illustrations/profiles/profile-1.png" /></div>
                            Alex Vidal
                        </div>
                    </td>
                    <td>contato@webav.com.br</td>
                    <td>Administrador</td>
                    <td>
                        <span class="badge bg-green-soft text-green">{{Sales}}</span>
                        <span class="badge bg-blue-soft text-blue">{{Developers}}</span>
                        <span class="badge bg-red-soft text-red">{{Marketing}}</span>
                        <span class="badge bg-purple-soft text-purple">{{Managers}}</span>
                        <span class="badge bg-yellow-soft text-yellow">{{Customer}}</span>
                    </td>
                    <td>20 Jun 2021</td>
                    <td>
                        <a class="btn btn-datatable btn-icon btn-transparent-dark me-2" href="{{TEMPLATE_URL}}{{#/dashboard/user-management-edit-user#}}"><i data-feather="edit"></i></a>
                        <a class="btn btn-datatable btn-icon btn-transparent-dark" href="#!"><i data-feather="trash-2"></i></a>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>