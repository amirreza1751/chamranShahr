<!-- Management Title Field -->
<div class="form-group col-sm-6">
    {!! Form::label('management_title', 'Management Title:') !!}
    {!! Form::text('management_title', null, ['class' => 'form-control']) !!}
</div>

<!-- English Management Title Field -->
<div class="form-group col-sm-6">
    {!! Form::label('english_management_title', 'English Management Title:') !!}
    {!! Form::text('english_management_title', null, ['class' => 'form-control']) !!}
</div>

<!-- Manager Title Field -->
<div class="form-group col-sm-6">
    {!! Form::label('manager_title', 'Manager Title:') !!}
    {!! Form::text('manager_title', null, ['class' => 'form-control']) !!}
</div>

<!-- English Manager Title Field -->
<div class="form-group col-sm-6">
    {!! Form::label('english_manager_title', 'English Manager Title:') !!}
    {!! Form::text('english_manager_title', null, ['class' => 'form-control']) !!}
</div>

<!-- Level Field -->
<div class="form-group col-sm-6">
    {!! Form::label('level', 'Level:') !!}
    {!! Form::number('level', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('manageLevels.index') !!}" class="btn btn-default">Cancel</a>
</div>
