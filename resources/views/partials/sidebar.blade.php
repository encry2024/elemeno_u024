@inject('request', 'Illuminate\Http\Request')
<!-- Left side column. contains the sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <ul class="sidebar-menu">
            <!--  -->
            @can('dashboard_access')
            <li class="{{ $request->segment(1) == 'home' ? 'active' : '' }}">
                <a href="{{ url('/admin/home') }}">
                    <i class="fa fa-tachometer "></i>
                    <span class="title">@lang('quickadmin.qa_dashboard')</span>
                </a>
            </li>
            @endcan
            <!--  -->

            <!--  -->
            @can('employee_record_access')
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-th"></i>
                    <span class="title">@lang('quickadmin.employee-record-management.title')</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">

                @can('employee_access')
                <li class="{{ $request->segment(2) == 'employee' ? 'active active-sub' : '' }}">
                        <a href="{{ route('admin.employee.index') }}">
                            <i class="fa fa-user"></i>
                            <span class="title">
                                @lang('quickadmin.employee.title')
                            </span>
                        </a>
                    </li>
                @endcan

                @can('department_access')
                <li class="{{ $request->segment(2) == 'department' ? 'active active-sub' : '' }}">
                        <a href="{{ route('admin.department.index') }}">
                            <i class="fa fa-building-o"></i>
                            <span class="title">
                                @lang('quickadmin.department.title')
                            </span>
                        </a>
                    </li>
                @endcan

                @can('position_access')
                <li class="{{ $request->segment(2) == 'position' ? 'active active-sub' : '' }}">
                        <a href="{{ route('admin.position.index') }}">
                            <i class="fa fa-plus"></i>
                            <span class="title">
                                @lang('quickadmin.position.title')
                            </span>
                        </a>
                    </li>
                @endcan
                </ul>
            </li>
            @endcan
            <!--  -->

            <!--  -->
            @can('attendance_record_management_access')
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-calendar"></i>
                    <span class="title">@lang('quickadmin.attendance-record-management.title')</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                @can('time_entries_access')
                <li class="{{ $request->segment(2) == 'time_entries' ? 'active active-sub' : '' }}">
                        <a href="{{ route('admin.time_entries.index') }}">
                            <i class="fa fa-clock-o"></i>
                            <span class="title">
                                @lang('quickadmin.time-entries.title')
                            </span>
                        </a>
                    </li>
                @endcan
                @can('attendance_report_access')
                <li class="{{ $request->segment(2) == 'attendance' ? 'active active-sub' : '' }}">
                        <a href="{{ route('admin.attendance.index') }}">
                            <i class="fa fa-list"></i>
                            <span class="title">
                                @lang('quickadmin.attendance.title')
                            </span>
                        </a>
                    </li>
                @endcan
                @can('holiday_access')
                <li class="{{ $request->segment(2) == 'holiday' ? 'active active-sub' : '' }}">
                        <a href="{{ route('admin.holiday.index') }}">
                            <i class="fa fa-calendar"></i>
                            <span class="title">
                                @lang('quickadmin.holiday.title')
                            </span>
                        </a>
                    </li>
                @endcan
                </ul>
            </li>
            @endcan
            <!--  -->

            <!--  -->
            @can('salary_record_management_access')
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-money"></i>
                    <span class="title">@lang('quickadmin.salary-record-management.title')</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">

                @can('computation_access')
                    <li class="{{ $request->segment(2) == 'salary' ? 'active active-sub' : '' }}">
                        <a href="{{ route('admin.salary.index') }}">
                            <i class="fa fa-calculator"></i>
                            <span class="title">
                                @lang('quickadmin.salary-computation.title')
                            </span>
                        </a>
                    </li>
                @endcan
                @can('cash_advance_access')
                    <li class="{{ $request->segment(2) == 'cash_advance' ? 'active active-sub' : '' }}">
                        <a href="{{ route('admin.cash_advance.index') }}">
                            <i class="fa fa-money"></i>
                            <span class="title">
                                @lang('quickadmin.cash_advance.title')
                            </span>
                        </a>
                    </li>
                @endcan
                @can('bonus_access')
                    <li class="{{ $request->segment(2) == 'bonus' ? 'active active-sub' : '' }}">
                        <a href="{{ route('admin.bonus.index') }}">
                            <i class="fa fa-money"></i>
                            <span class="title">
                                @lang('quickadmin.bonus.title')
                            </span>
                        </a>
                    </li>
                @endcan
                @can('backpay_access')
                    <li class="{{ $request->segment(2) == 'backpay' ? 'active active-sub' : '' }}">
                        <a href="{{ route('admin.backpay.index') }}">
                            <i class="fa fa-money"></i>
                            <span class="title">
                                @lang('quickadmin.backpay.title')
                            </span>
                        </a>
                    </li>
                @endcan
                @can('13month_access')
                    <li class="{{ $request->segment(2) == 'month13' ? 'active active-sub' : '' }}">
                        <a href="{{ route('admin.month13.index') }}">
                            <i class="fa fa-money"></i>
                            <span class="title">
                                @lang('quickadmin.13month.title')
                            </span>
                        </a>
                    </li>
                @endcan
                @can('leaveconversion_access')
                    <li class="{{ $request->segment(2) == 'leaveconversion' ? 'active active-sub' : '' }}">
                        <a href="{{ route('admin.leaveconversion.index') }}">
                            <i class="fa fa-money"></i>
                            <span class="title">
                                @lang('quickadmin.leaveconversion.title')
                            </span>
                        </a>
                    </li>
                @endcan
                </ul>
            </li>
            @endcan
            <!--  -->
            
            <!--  -->
            @can('user_management_access')
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-users"></i>
                    <span class="title">@lang('quickadmin.user-management.title')</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">

                @can('role_access')
                <li class="{{ $request->segment(2) == 'roles' ? 'active active-sub' : '' }}">
                        <a href="{{ route('admin.roles.index') }}">
                            <i class="fa fa-briefcase"></i>
                            <span class="title">
                                @lang('quickadmin.roles.title')
                            </span>
                        </a>
                    </li>
                @endcan

                @can('user_access')
                <li class="{{ $request->segment(2) == 'users' ? 'active active-sub' : '' }}">
                        <a href="{{ route('admin.users.index') }}">
                            <i class="fa fa-user"></i>
                            <span class="title">
                                @lang('quickadmin.users.title')
                            </span>
                        </a>
                    </li>
                @endcan
                </ul>
            </li>
            @endcan
            
            <li class="{{ $request->segment(2) == 'reports' ? 'active active-sub' : '' }}">
                <a href="{{ route('admin.reports.index') }}">
                    <i class="fa fa-line-chart"></i>
                    <span class="title">Report</span>
                </a>
            </li>

            @can('log_access')
            <li class="{{ $request->segment(2) == 'logs' ? 'active active-sub' : '' }}">
                <a href="{{ route('admin.logs.index') }}">
                    <i class="fa fa-file"></i>
                    <span class="title">Logs</span>
                </a>
            </li>
            @endcan

            <li>
                <a href="#logout" onclick="$('#logout').submit();">
                    <i class="fa fa-arrow-left"></i>
                    <span class="title">@lang('quickadmin.qa_logout')</span>
                </a>
            </li>
        </ul>
    </section>
</aside>
{!! Form::open(['route' => 'auth.logout', 'style' => 'display:none;', 'id' => 'logout']) !!}
<button type="submit">@lang('quickadmin.logout')</button>
{!! Form::close() !!}
