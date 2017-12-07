@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.salary-record-management.title')</h3>
    
    @can('computation_create')
        {!! Form::open([
            'method' => 'POST', 
            'onsubmit' => "return confirm('Do you want to RUN PAYROLL');", 
            'url' => url('admin/salary/run_payroll'), 
            'class' => 'form']) !!}
        <div class="row" style="margin: 1% auto;">
            <div class="col-xs-2 col-md-2 form-group">
                {!! Form::label('from','From',['class' => 'control-label']) !!}
                {!! Form::text('from', date('m-d-Y', strtotime('-15 days')) ,['class' => 'form-control date']) !!}
            </div>
            <div class="col-xs-2 col-md-2 form-group">
                {!! Form::label('to','To',['class' => 'control-label']) !!}
                {!! Form::text('to', date('m-d-Y') ,['class' => 'form-control date']) !!}
            </div>
            <div class="col-xs-1 col-md-2 form-group">
                <div class="row" style="margin-top:10px">
                    {!! Form::checkbox('contribution') !!}
                    {!! Form::label('contribution', 'Contribution',['class' => 'control-label']) !!}
                </div>
                <div class="row">
                    {!! Form::checkbox('tax') !!}
                    {!! Form::label('tax', 'W/ Tax',['class' => 'control-label']) !!}
                </div>
                
            </div>
            <div class="form-group col-xs-2 col-offset-1">
                {!! Form::submit(trans('quickadmin.qa_run'), ['class' => 'btn btn-success', 'style' => 'margin-top:25px;margin-left:-70px']) !!}
            </div>
        </div>
        {!! Form::close() !!}
    @endcan

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.qa_list')
        </div>

        <div class="panel-body table-responsive">
            <table class="table table-bordered table-striped {{ count($employees) > 0 ? 'datatable' : '' }} @can('salary_delete') dt-select @endcan">
                <thead>
                    <tr>
                        @can('computation_delete')
                            <th style="text-align:center;"><input type="checkbox" id="select-all" /></th>
                        @endcan

                        <th>@lang('quickadmin.salary-computation.fields.id')</th>
                        <th>@lang('quickadmin.salary-computation.fields.date')</th>
                        <th>@lang('quickadmin.salary-computation.fields.days')</th>
                        <th>@lang('quickadmin.salary-computation.fields.gross')</th>
                        <th>@lang('quickadmin.salary-computation.fields.deduction')</th>
                        <th>@lang('quickadmin.salary-computation.fields.net')</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    @if (count($employees) > 0)
                        @foreach ($employees as $employee)
                            @foreach($employee->salaries as $salary)
                            <tr data-entry-id="{{ $salary->id }}">
                                @can('computation_delete')
                                    <td></td>
                                @endcan
                                <td>{{ $employee->employee_no }}</td>
                                <td>{{ $salary->date }}</td>
                                <td>{{ $salary->days }}</td>
                                <td>{{ number_format($salary->gross, 2) }}</td>
                                <td>{{ number_format($salary->total_deductions, 2) }}</td>
                                <td>{{ number_format($salary->net_pay, 2) }}</td>
                                <td>
                                    @can('computation_view')
                                    <a href="{{ route('admin.salary.print', [$salary->id]) }}" class="btn btn-xs btn-success">
                                        Print
                                    </a>
                                    <a href="{{ route('admin.salary.show',[$salary->id]) }}" class="btn btn-xs btn-primary">
                                        @lang('quickadmin.qa_view')
                                    </a>
                                    @endcan
                                    @can('computation_edit')
                                    <a href="{{ route('admin.salary.edit',[$salary->id]) }}" class="btn btn-xs btn-info">
                                        @lang('quickadmin.qa_edit')
                                    </a>
                                    @endcan
                                    @can('computation_delete')
                                    {!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'DELETE',
                                        'onsubmit' => "return confirm('".trans("quickadmin.pr_are_you_sure")."');",
                                        'route' => ['admin.salary.destroy', $salary->id])) !!}
                                    {!! Form::submit(trans('quickadmin.pr_delete'), array('class' => 'btn btn-xs btn-danger')) !!}
                                    {!! Form::close() !!}
                                    @endcan
                                </td>
                            </tr>
                            @endforeach
                        @endforeach
                    @else
                        <tr>
                            <td colspan="8">@lang('quickadmin.qa_no_entries_in_table')</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
@stop

@section('javascript')
    <script>
        @can('computation_delete')
            window.route_mass_crud_entries_destroy = '{{ route('admin.salary.mass_destroy') }}';
        @endcan

    </script>
@endsection
