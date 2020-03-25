<!-- Manage Type Field -->
<div class="form-group col-sm-6">
    {!! Form::label('manage_type', 'Manage Type:') !!}
    {!! Form::text('manage_type', null, ['class' => 'form-control']) !!}
</div>

<!-- Manage Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('manage_id', 'Manage Id:') !!}
    {!! Form::number('manage_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Managed By Type Field -->
<div class="form-group col-sm-6">
    {!! Form::label('managed_by_type', 'Managed By Type:') !!}
    {!! Form::text('managed_by_type', null, ['class' => 'form-control']) !!}
</div>

<!-- Managed By Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('managed_by_id', 'Managed By Id:') !!}
    {!! Form::number('managed_by_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('manageHierarchies.index') !!}" class="btn btn-default">Cancel</a>
</div>
