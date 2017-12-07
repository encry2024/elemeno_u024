@extends('layouts.app')

@section('content')
    <h3 class="page-title">LOGS</h3>

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.qa_list')
        </div>

        <div class="panel-body table-responsive">
            <table class="table table-bordered table-striped {{ count($logs) > 0 ? 'datatable' : '' }}">
                <thead>
                <tr>
                    <th>DATE</th>
                    <th>NAME</th>
                    <th>TYPE</th>
                </tr>
                </thead>
                <tbody>
                @if (count($logs) > 0)
                    @foreach ($logs as $log)
                        <tr data-entry-id="{{ $log->id }}">
                            <td>{{ $log->date }}</td>
                            <td>{{ $log->name }}</td>
                            <td>{{ $log->type }}</td>
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