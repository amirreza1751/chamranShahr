<!-- User Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('user_id', 'User Id:') !!}
    {!! Form::number('user_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Study Area Unique Code Field -->
<div class="form-group col-sm-6">
    {!! Form::label('study_area_unique_code', 'Study Area Unique Code:') !!}
    {!! Form::text('study_area_unique_code', null, ['class' => 'form-control']) !!}
</div>

<!-- Study Level Unique Code Field -->
<div class="form-group col-sm-6">
    {!! Form::label('study_level_unique_code', 'Study Level Unique Code:') !!}
    {!! Form::text('study_level_unique_code', null, ['class' => 'form-control']) !!}
</div>

<!-- Entrance Term Unique Code Field -->
<div class="form-group col-sm-6">
    {!! Form::label('entrance_term_unique_code', 'Entrance Term Unique Code:') !!}
    {!! Form::text('entrance_term_unique_code', null, ['class' => 'form-control']) !!}
</div>

<!-- Study Status Unique Code Field -->
<div class="form-group col-sm-6">
    {!! Form::label('study_status_unique_code', 'Study Status Unique Code:') !!}
    {!! Form::text('study_status_unique_code', null, ['class' => 'form-control']) !!}
</div>

<!-- Total Average Field -->
<div class="form-group col-sm-6">
    {!! Form::label('total_average', 'Total Average:') !!}
    {!! Form::number('total_average', null, ['class' => 'form-control']) !!}
</div>

<!-- Is Active Field -->
<div class="form-group col-sm-6">
    {!! Form::label('is_active', 'Is Active:') !!}
    <label class="checkbox-inline">
        {!! Form::hidden('is_active', 0) !!}
        {!! Form::checkbox('is_active', '1', null) !!}
    </label>
</div>


<!-- Is Guest Field -->
<div class="form-group col-sm-6">
    {!! Form::label('is_guest', 'Is Guest:') !!}
    <label class="checkbox-inline">
        {!! Form::hidden('is_guest', 0) !!}
        {!! Form::checkbox('is_guest', '1', null) !!}
    </label>
</div>


<!-- Is Iranian Field -->
<div class="form-group col-sm-6">
    {!! Form::label('is_iranian', 'Is Iranian:') !!}
    <label class="checkbox-inline">
        {!! Form::hidden('is_iranian', 0) !!}
        {!! Form::checkbox('is_iranian', '1', null) !!}
    </label>
</div>


<!-- In Dormitory Field -->
<div class="form-group col-sm-6">
    {!! Form::label('in_dormitory', 'In Dormitory:') !!}
    <label class="checkbox-inline">
        {!! Form::hidden('in_dormitory', 0) !!}
        {!! Form::checkbox('in_dormitory', '1', null) !!}
    </label>
</div>


<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('students.index') !!}" class="btn btn-default">Cancel</a>
</div>
