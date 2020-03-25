<!-- Id Field -->
<div class="form-group">
    {!! Form::label('id', 'Id:') !!}
    <p>{!! $studyStatus->id !!}</p>
</div>

<!-- Title Field -->
<div class="form-group">
    {!! Form::label('title', 'Title:') !!}
    <p>{!! $studyStatus->title !!}</p>
</div>

<!-- English Title Field -->
<div class="form-group">
    {!! Form::label('english_title', 'English Title:') !!}
    <p>{!! $studyStatus->english_title !!}</p>
</div>

<!-- Unique Code Field -->
<div class="form-group">
    {!! Form::label('unique_code', 'Unique Code:') !!}
    <p>{!! $studyStatus->unique_code !!}</p>
</div>

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{!! $studyStatus->created_at !!}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{!! $studyStatus->updated_at !!}</p>
</div>

<!-- Deleted At Field -->
<div class="form-group">
    {!! Form::label('deleted_at', 'Deleted At:') !!}
    <p>{!! $studyStatus->deleted_at !!}</p>
</div>

