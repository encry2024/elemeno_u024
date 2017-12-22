@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.13month.title')</h3>
    @can('13month_create')
    <p>
        <a href="{{ route('admin.month13.show', ['generate']) }}" class="btn btn-success">@lang('quickadmin.13month.generate')</a>
    </p>
    @endcan

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.qa_list')
        </div>

        <div class="panel-body table-responsive">
            <table class="table table-bordered table-striped {{ count($bonuses) > 0 ? 'datatable' : '' }} @can('13month_delete') dt-select @endcan">
                <thead>
                    <tr>
                        @can('13month_delete')
                            <th style="text-align:center;"><input type="checkbox" id="select-all" /></th>
                        @endcan

                        <th>@lang('quickadmin.13month.fields.employee')</th>
                        <th>@lang('quickadmin.13month.fields.date')</th>
                        <th>@lang('quickadmin.13month.fields.amount')</th>
                        <th>@lang('quickadmin.13month.fields.tax')</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    @if (count($bonuses) > 0)
                        @foreach ($bonuses as $bonus)
                            <tr data-entry-id="{{ $bonus->id }}">
                                @can('13month_delete')
                                    <td></td>
                                @endcan
                                <td>{{ $bonus->employee->fullname() }}</td>
                                <td>{{ $bonus->date }}</td>
                                <td>{{ $bonus->amount }}</td>
                                <td>{{ $bonus->tax }}</td>
                                <td>
                                    @can('13month_edit')
                                    <a href="{{ route('admin.month13.edit',[$bonus->id]) }}" class="btn btn-xs btn-primary">@lang('quickadmin.qa_edit')</a>
                                    @endcan
                                    @can('13month_delete')
                                    {!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'DELETE',
                                        'onsubmit' => "return confirm('".trans("quickadmin.qa_are_you_sure")."');",
                                        'route' => ['admin.month13.destroy', $bonus->id])) !!}
                                    {!! Form::submit(trans('quickadmin.qa_delete'), array('class' => 'btn btn-xs btn-danger')) !!}
                                    {!! Form::close() !!}
                                    @endcan
                                </td>
                            </tr>
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
        @can('13month_delete')
            window.route_mass_crud_entries_destroy = '{{ route('admin.month13.mass_destroy') }}';
        @endcan

    </script>
@endsection