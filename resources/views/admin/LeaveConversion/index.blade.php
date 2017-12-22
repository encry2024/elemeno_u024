@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.leaveconversion.title')</h3>
     @can('computation_create')
        {!! Form::open([
            'method' => 'POST', 
            'onsubmit' => "return confirm('Do you want to Convert Leave?');", 
            'url' => url('admin/leaveconversion/convert'), 
            'class' => 'form']) !!}
        <div class="row" style="margin: 1% auto;">
            <div class="col-xs-2 col-md-2 form-group">
                {!! Form::label('from','From',['class' => 'control-label']) !!}
                {!! Form::text('from', date('01-01-Y') ,['class' => 'form-control date']) !!}
            </div>
            <div class="col-xs-2 col-md-2 form-group">
                {!! Form::label('to','To',['class' => 'control-label']) !!}
                {!! Form::text('to', date('12-31-Y') ,['class' => 'form-control date']) !!}
            </div>
            <div class="form-group col-xs-2 col-offset-1">
                {!! Form::submit('Convert Leave', ['class' => 'btn btn-success', 'style' => 'margin-top:25px']) !!}
            </div>
        </div>
        {!! Form::close() !!}
    @endcan

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.qa_list')
        </div>

        <div class="panel-body table-responsive">
            <table class="table table-bordered table-striped {{ count($converted) > 0 ? 'datatable' : '' }} @can('leaveconversion_delete') dt-select @endcan">
                <thead>
                    <tr>
                        @can('leaveconversion_delete')
                            <th style="text-align:center;"><input type="checkbox" id="select-all" /></th>
                        @endcan

                        <th>@lang('quickadmin.leaveconversion.fields.id')</th>
                        <th>@lang('quickadmin.leaveconversion.fields.leave')</th>
                        <th>@lang('quickadmin.leaveconversion.fields.amount')</th>
                        <th>@lang('quickadmin.leaveconversion.fields.date')</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    @if(count($converted))
                    @foreach($converted as $convert)
                    <tr data-entry-id="{{ $convert->id }}">
                        @can('leaveconversion_delete')
                        <td></td>
                        @endcan

                        <td>{{ $convert->employee->employee_no }}</td>
                        <td>{{ $convert->unused_leave }}</td>
                        <td>{{ number_format($convert->amount, 2) }}</td>
                        <td>{{ $convert->date }}</td>
                        <td>
                            @can('leaveconversion_delete')
                            {!! Form::open(array(
                                'style' => 'display: inline-block;',
                                'method' => 'DELETE',
                                'onsubmit' => "return confirm('".trans("quickadmin.qa_are_you_sure")."');",
                                'route' => ['admin.leaveconversion.destroy', $convert->id])) !!}
                            {!! Form::submit(trans('quickadmin.qa_delete'), array('class' => 'btn btn-xs btn-danger')) !!}
                            {!! Form::close() !!}
                            @endcan
                        </td>
                    </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
@stop
@section('javascript')
    <script>
        @can('leaveconversion_delete')
            window.route_mass_crud_entries_destroy = '{{ route('admin.leaveconversion.mass_destroy') }}';
        @endcan

    </script>
@endsection
