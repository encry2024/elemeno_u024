@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.cash_advance.title')</h3>
    @can('cash_advance_create')
    <p>
        <a href="{{ route('admin.cash_advance.create') }}" class="btn btn-success">@lang('quickadmin.qa_add_new')</a>
    </p>
    @endcan

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.qa_list')
        </div>

        <div class="panel-body table-responsive">
            <table class="table table-bordered table-striped {{ count($cash_advances) > 0 ? 'datatable' : '' }} @can('cash_advance_delete') dt-select @endcan">
                <thead>
                    <tr>
                        @can('cash_advance_delete')
                            <th style="text-align:center;"><input type="checkbox" id="select-all" /></th>
                        @endcan

                        <th>@lang('quickadmin.cash_advance.fields.employee')</th>
                        <th>@lang('quickadmin.cash_advance.fields.amount')</th>
                        <th>@lang('quickadmin.cash_advance.fields.date')</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    @if (count($cash_advances) > 0)
                        @foreach ($cash_advances as $cash_advance)
                            <tr data-entry-id="{{ $cash_advance->id }}">
                                @can('cash_advance_delete')
                                    <td></td>
                                @endcan
                                <td>{{ $cash_advance->employee->fullname() }}</td>
                                <td>{{ $cash_advance->amount }}</td>
                                <td>{{ $cash_advance->created_at->format('Y-m-d') }}</td>
                                <td>
                                    @can('cash_advance_view')
                                    <a href="{{ route('admin.cash_advance.show',[$cash_advance->id]) }}" class="btn btn-xs btn-primary">@lang('quickadmin.qa_view')</a>
                                    @endcan
                                    @can('cash_advance_edit')
                                    <a href="{{ route('admin.cash_advance.edit',[$cash_advance->id]) }}" class="btn btn-xs btn-info">@lang('quickadmin.qa_edit')</a>
                                    @endcan
                                    @can('cash_advance_delete')
                                    {!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'DELETE',
                                        'onsubmit' => "return confirm('".trans("quickadmin.qa_are_you_sure")."');",
                                        'route' => ['admin.cash_advance.destroy', $cash_advance->id])) !!}
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
        @can('cash_advance_delete')
            window.route_mass_crud_entries_destroy = '{{ route('admin.cash_advance.mass_destroy') }}';
        @endcan

    </script>
@endsection