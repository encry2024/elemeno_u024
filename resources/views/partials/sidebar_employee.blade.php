@inject('request', 'Illuminate\Http\Request')
<!-- Left side column. contains the sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <ul class="sidebar-menu">

            <!-- Only employee can view menu -->
            <li class="{{ $request->segment(2) == 'info' ? 'active active-sub' : '' }}">
                <a href="{{ route('employee.info.index') }}">
                    <i class="fa fa-user"></i>
                    <span class="title">Employee</span>
                </a>
            </li>
            <li class="{{ $request->segment(2) == 'overtime' ? 'active active-sub' : '' }}">
                <a href="{{ route('employee.overtime.index') }}">
                    <i class="fa fa-clock-o"></i>
                    <span class="title">Request Overtime</span>
                </a>
            </li>
            <li class="{{ $request->segment(2) == 'leave' ? 'active active-sub' : '' }}">
                <a href="{{ route('employee.leave.index') }}">
                    <i class="fa fa-file-text-o"></i>
                    <span class="title">Leave Request</span>
                </a>
            </li>
            <li class="{{ $request->segment(2) == 'loan' ? 'active active-sub' : '' }}">
                <a href="{{ route('employee.loan.index') }}">
                    <i class="fa fa-money"></i>
                            <span class="title">
                                @lang('quickadmin.loan.title')
                            </span>
                </a>
            </li>
            <li class="{{ $request->segment(2) == 'summary' ? 'active active-sub' : '' }}">
                <a href="{{ route('employee.summary.index') }}">
                    <i class="fa fa-file-text-o"></i>
                    <span class="title">PayOut History</span>
                </a>
            </li>
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
