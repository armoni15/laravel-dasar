<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="/anm/dashboard" class="brand-link">
    <img src="/images/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light">ANM Ardbeater</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item">
          <a href="/anm/dashboard" class="nav-link {{ Request::is('anm/dashboard') ? 'active' : '' }}">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>
              Dashboard
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="/anm/companies" class="nav-link {{ Request::is('anm/companies*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-building"></i>
            <p>
              Companies
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="/anm/employees" class="nav-link {{ Request::is('employees*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-users"></i>
            <p>
              Employees
            </p>
          </a>
        </li>
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>