<!-- Unique Code Field -->
<div class="form-group col-sm-6">
    {!! Form::label('unique_code', 'Unique Code:') !!}
    {!! Form::text('unique_code', null, ['class' => 'form-control']) !!}
</div>

<!-- Faculty Unique Code Field -->
<div class="form-group col-sm-6">
    {!! Form::label('faculty_unique_code', 'Faculty Unique Code:') !!}
    {!! Form::text('faculty_unique_code', null, ['class' => 'form-control']) !!}
</div>

<!-- Department Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('department_id', 'Department Id:') !!}
    {!! Form::number('department_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('studyFields.index') !!}" class="btn btn-default">Cancel</a>
</div>
