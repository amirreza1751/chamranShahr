<!-- Title Field -->
<div class="form-group col-sm-6">
    {!! Form::label('title', 'Title:') !!}
    {!! Form::text('title', null, ['class' => 'form-control']) !!}
</div>

<!-- English Title Field -->
<div class="form-group col-sm-6">
    {!! Form::label('english_title', 'English Title:') !!}
    {!! Form::text('english_title', null, ['class' => 'form-control']) !!}
</div>

<!-- Unique Code Field -->
<div class="form-group col-sm-6">
    {!! Form::label('unique_code', 'Unique Code:') !!}
    {!! Form::text('unique_code', null, ['class' => 'form-control']) !!}
</div>

<!-- Is Active Field -->
<div class="form-group col-sm-6">
    {!! Form::label('is_active', 'Is Active:') !!}
    <label class="checkbox-inline">
        {!! Form::hidden('is_active', 0) !!}
        {!! Form::checkbox('is_active', '1', null) !!}
    </label>
</div>


<!-- Study Level Unique Code Field -->
<div class="form-group col-sm-6">
    {!! Form::label('study_level_unique_code', 'Study Level Unique Code:') !!}
    {!! Form::text('study_level_unique_code', null, ['class' => 'form-control']) !!}
</div>

<!-- Study Field Unique Code Field -->
<div class="form-group col-sm-6">
    {!! Form::label('study_field_unique_code', 'Study Field Unique Code:') !!}
    {!! Form::text('study_field_unique_code', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('studyAreas.index') !!}" class="btn btn-default">Cancel</a>
</div>
