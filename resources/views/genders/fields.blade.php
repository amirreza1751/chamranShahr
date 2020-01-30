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

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('genders.index') !!}" class="btn btn-default">Cancel</a>
</div>
