@inject('request', 'Illuminate\Http\Request')
<header class="main-header">
    <!-- Logo -->

    <a href="{{ $request->segment(1) == 'admin' ? url('/admin/home') : url('/employee/info') }}" class="logo"
       style="font-size: 16px;">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini">
            {{ $request->segment(1) == 'admin' ? 'Payroll System' : 'Company Name' }}  
        </span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg">
           {{ $request->segment(1) == 'admin' ? 'Payroll System' : 'Company Name' }}
        </span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </a>

        

    </nav>
</header>


