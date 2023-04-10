<a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse"
   data-bs-target="#appsCollapseExampleManagement" aria-expanded="false"
   aria-controls="appsCollapseExampleManagement">
    <div class="nav-link-icon"><i data-feather="examples"></i></div>
    {{Examples}}
    <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
</a>
<div class="collapse" id="appsCollapseExampleManagement" data-menu-id="example-management" data-bs-parent="#accordionSidenavAppsMenu">
    <nav class="sidenav-menu-nested nav">
        <a class="nav-link" data-menu-id="example-management" href="{{TEMPLATE_URL}}{{#/dashboard/examples/all#}}">{{Examples List}}</a>
        <a class="nav-link" data-menu-id="example-management" href="{{TEMPLATE_URL}}{{#/dashboard/examples/store#}}">{{Add Example}}</a>
        <a class="nav-link" data-menu-id="example-management" href="{{TEMPLATE_URL}}{{#/dashboard/examples/trash#}}">{{Trash}}</a>
    </nav>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        initializeMenu('example-management');
    });
</script>