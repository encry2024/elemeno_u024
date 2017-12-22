@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.position.title')</h3>

    {!! Form::model($position,
       ['method' => 'PUT',
       'onsubmit' => "return confirm('".trans("quickadmin.qa_are_you_sure")."')",
       'route' => ['admin.position.update', $position->id]]) !!}

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.qa_edit')
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="col-xs-4 form-group {{ $errors->has('employee_id') ? 'has-error' : '' }}">
                    {!! Form::label('employee_id', 'Full Name*', ['class' => 'control-label']) !!}
                    {!! Form::text('employee_id', $employee->id, ['class' => 'form-control']) !!}
                    {!! Form::text('employee_name', $employee->fullname(), ['class' => 'form-control']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('employee_id'))
                        <p class="help-block">
                            {{ $errors->first('employee_id') }}
                        </p>
                    @endif
                </div>
                <div class="col-xs-4 form-group {{ $errors->has('department_id') ? 'has-error' : '' }}">
                    {!! Form::label('department_id', 'Department*', ['class' => 'control-label']) !!}
                    {!! Form::select('department_id', $department, old('department_id'), ['class' => 'form-control select2']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('department_id'))
                        <p class="help-block">
                            {{ $errors->first('department_id') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-4 form-group {{ $errors->has('position') ? 'has-error' : '' }}">
                    {!! Form::label('position', 'Position*', ['class' => 'control-label']) !!}
                    {!! Form::text('position', old('position'), ['class' => 'form-control']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('position'))
                        <p class="help-block">
                            {{ $errors->first('position') }}
                        </p>
                    @endif
                </div>
                <div class="col-xs-4 form-group {{ $errors->has('rate') ? 'has-error' : '' }}">
                    {!! Form::label('rate', 'Rate*', ['class' => 'control-label']) !!}
                    {!! Form::text('rate', old('rate'), ['class' => 'form-control']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('rate'))
                        <p class="help-block">
                            {{ $errors->first('rate') }}
                        </p>
                    @endif
                </div>
            </div>

            <div class="row">
                <div class="col-xs-4 form-group {{ $errors->has('allowance_description') ? 'has-error' : '' }}">
                    {!! Form::label('allowance_description', 'Allowance Description*', ['class' => 'control-label']) !!}
                    {!! Form::select('allowance_description',
                            [
                                1 => 'None', 'Transportation', 'Clothes', 'Meals', 'Refresentation', 'Communication'
                            ],
                            old('allowance_description'),
                            [
                                'class' => 'form-control'
                            ])
                        !!}
                    <p class="help-block"></p>
                    @if($errors->has('allowance_description'))
                        <p class="help-block">
                            {{ $errors->first('allowance_description') }}
                        </p>
                    @endif
                </div>
                <div class="col-xs-3 form-group {{ $errors->has('allowance') ? 'has-error' : '' }}">
                    {!! Form::label('allowance', 'Allowance*', ['class' => 'control-label']) !!}
                    {!! Form::text('allowance', old('allowance'), ['class' => 'form-control']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('allowance'))
                        <p class="help-block">
                            {{ $errors->first('allowance') }}
                        </p>
                    @endif
                </div>
                <div class="col-xs-3 form-group">
                    <a class="btn btn-primary" href="#" id="btn_add" style="margin-top: 20px">
                        <span class="fa fa-plus"></span> ADD</a>
                </div>
            </div>

            <div id="inputs">
                <?php
                    if(count($employee->allowances))
                    {
                        for($i = 1; $i <= count($employee->allowances); $i++)
                        {
                            echo '<div id="allowance_'.$employee->allowances[$i - 1]['id'].'"">';
                            echo '<input type="hidden" name="desc_'.$i.'" value="'.$employee->allowances[$i - 1]['type'].'">';
                            echo '<input type="hidden" name="input_'.$i.'" value="'.$employee->allowances[$i - 1]['amount'].'">';
                            echo '</div>';
                        }
                    }
                ?>
            </div>

            <div class="row">
                <div class="col-md-8">
                    <table class="table table-hover table-bordered">
                        <thead>
                        <th>Allowance Description</th>
                        <th>Amount</th>
                        <th>&nbsp;</th>
                        </thead>
                        <tbody id="tbl_allowance" name="table_body">
                            @if(count($employee->allowances))
                                @foreach($employee->allowances as $allowance)
                                    <tr id="{{$allowance->id}}">
                                        <td>{{ $allowance->type }}</td>
                                        <td>{{ $allowance->amount }}</td>
                                        <td><a href="#" onclick="remove({{ $allowance->id }})">Remove</a></td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>

    {!! Form::submit(trans('quickadmin.qa_update'), ['class' => 'btn btn-danger']) !!}
    {!! Form::close() !!}
@stop

@section('javascript')
    @parent
    <script src="{{ url('quickadmin/js') }}/timepicker.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.4.5/jquery-ui-timepicker-addon.min.js"></script>
    <script src="https://cdn.datatables.net/select/1.2.0/js/dataTables.select.min.js"></script>    <script>
        var i = '{{ count($employee->allowances ) ? count($employee->allowances) + 1 : 0}}';
        $('.datetime').datetimepicker({
            autoclose: true,
            dateFormat: "{{ config('app.date_format_js') }}",
            timeFormat: "HH:mm:ss"
        });

        $('#btn_add').on('click', function(){
            var type    = $('#allowance_description').val();
            var amount  = $('#allowance').val();

            i = i == 0 ? 1 : i;

            if((type != '' || type != 'None' ) && (amount != 0 || amount != ''))
            {
                var desc    =  ['None', 'Transportation', 'Clothes', 'Meals', 'Refresentation', 'Communication'];
                var html    =  '<tr id=' + i + '>';
                html    += '<td>' + desc[type - 1] + '</td>';
                html    += '<td>' + amount + '</td>';
                html    += '<td><a href="#" onclick="remove(' + i + ')">Remove</a></td>';
                html    += '</tr>';

                var input   = '<div id="allowance_'+ i +'"><input type="hidden" name="input_'+ i + '"  value="' + amount + '">';
                input   += '<input type="hidden" name="desc_' + i + '"  value="' + type +'"></div>';

                $('#tbl_allowance').append(html);
                $('#allowance').val(null);
                $('#allowance_description').val(null);

                $('#inputs').append(input);
            }

        });

        function remove(e){
            $('tr#'+e).remove();
            $('div#allowance_'+e).remove();

            window.location = '{{ url("/") }}' + '/admin/allowance/' + e + '/delete';
        }
    </script>

@stop
