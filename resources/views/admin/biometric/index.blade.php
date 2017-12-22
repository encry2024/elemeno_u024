@extends('layouts.app')

@section('content')
    <h3 class="page-title">Biometric Management</h3>
    @can('biometric_create')
    <p>
        <a href="{{ route('admin.biometric.create') }}" class="btn btn-success">Add New Biometric</a>
        
    </p>
    @endcan

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.qa_list')
        </div>

        <div class="panel-body table-responsive">
            <table class="table table-bordered table-striped {{ count($biometrics) > 0 ? 'datatable' : '' }} @can('biometric_delete') dt-select @endcan">
                <thead>
                    <tr>
                        @can('biometric_delete')
                            <th style="text-align:center;"><input type="checkbox" id="select-all" /></th>
                        @endcan

                        <th>ID</th>
                        <th>Device Name</th>
                        <th>Serial Number</th>
                        <th>Verification Code</th>
                        <th>Activation Code</th>
                        <th>Verification Key</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                
                <tbody>
                    @if (count($biometrics) > 0)
                        @foreach ($biometrics as $biometric)
                            <tr data-entry-id="{{ $biometric->id }}">
                                @can('biometric_delete')
                                    <td></td>
                                @endcan

                                <td>{{ count($biometric) ? $biometric->name : 'n/a' }}</td>
                                <td>{{ $biometric->name }}</td>
                                <td>{{ str_limit($biometric->sn, 10) }}</td>
                                <td>{{ str_limit($biometric->vc, 10) }}</td>
                                <td>{{ str_limit($biometric->ac, 10) }}</td>
                                <td>{{ str_limit($biometric->vkey, 10) }}</td>
                                <td>
                                    @can('biometric_view')
                                        <a href="{{ route('admin.biometric.show',[$biometric->id]) }}" class="btn btn-xs btn-primary">@lang('quickadmin.qa_view')</a>
                                    @endcan
                                    @can('biometric_edit')
                                        <a href="{{ route('admin.biometric.edit',[$biometric->id]) }}" class="btn btn-xs btn-info">@lang('quickadmin.qa_edit')</a>
                                    @endcan
                                    @can('biometric_delete')
                                        {!! Form::open(array(
                                            'style' => 'display: inline-block;',
                                            'method' => 'DELETE',
                                            'onsubmit' => "return confirm('".trans("quickadmin.qa_are_you_sure")."');",
                                            'route' => ['admin.biometric.destroy', $biometric->id])) !!}
                                        {!! Form::submit(trans('quickadmin.qa_delete'), array('class' => 'btn btn-xs btn-danger')) !!}
                                        {!! Form::close() !!}
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="9">filtered from 1 total entries</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
@stop

@section('javascript') 
    <script>
        @can('biometric_delete')
            // window.route_mass_crud_entries_destroy = '{{ route('admin.biometric.mass_destroy') }}';
        @endcan
    </script>
@endsection