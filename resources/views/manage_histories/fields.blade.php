<!-- Manager Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('manager_id', 'Manager Id:') !!}
    {!! Form::number('manager_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Managed Type Field -->
<div class="form-group col-sm-6">
    {!! Form::label('managed_type', 'Managed Type:') !!}
    {!! Form::text('managed_type', null, ['class' => 'form-control']) !!}
</div>

<!-- Managed Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('managed_id', 'Managed Id:') !!}
    {!! Form::number('managed_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Begin Date Field -->
<div class="form-group col-sm-6">
    {!! Form::label('begin_date', 'Begin Date:') !!}
    {!! Form::date('begin_date', null, ['class' => 'form-control','id'=>'begin_date']) !!}
</div>

@section('scripts')
    <script type="text/javascript">
        $('#begin_date').datetimepicker({
            format: 'YYYY-MM-DD HH:mm:ss',
            useCurrent: false
        })
    </script>
@endsection

<!-- End Date Field -->
<div class="form-group col-sm-6">
    {!! Form::label('end_date', 'End Date:') !!}
    {!! Form::date('end_date', null, ['class' => 'form-control','id'=>'end_date']) !!}
</div>

@section('scripts')
    <script type="text/javascript">
        $('#end_date').datetimepicker({
            format: 'YYYY-MM-DD HH:mm:ss',
            useCurrent: false
        })
    </script>
@endsection

<!-- Is Active Field -->
<div class="form-group col-sm-6">
    {!! Form::label('is_active', 'Is Active:') !!}
    <label class="checkbox-inline">
        {!! Form::hidden('is_active', 0) !!}
        {!! Form::checkbox('is_active', '1', null) !!}
    </label>
</div>


<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('manageHistories.index') !!}" class="btn btn-default">Cancel</a>
</div>
