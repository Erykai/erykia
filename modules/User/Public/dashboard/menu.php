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