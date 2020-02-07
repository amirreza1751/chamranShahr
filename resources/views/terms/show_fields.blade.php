<!-- Id Field -->
<div class="form-group">
    {!! Form::label('id', 'Id:') !!}
    <p>{!! $term->id !!}</p>
</div>

<!-- Title Field -->
<div class="form-group">
    {!! Form::label('title', 'Title:') !!}
    <p>{!! $term->title !!}</p>
</div>

<!-- Unique Code Field -->
<div class="form-group">
    {!! Form::label('unique_code', 'Unique Code:') !!}
    <p>{!! $term->unique_code !!}</p>
</div>

<!-- Term Code Field -->
<div class="form-group">
    {!! Form::label('term_code', 'Term Code:') !!}
    <p>{!! $term->term_code !!}</p>
</div>

<!-- Begin Date Field -->
<div class="form-group">
    {!! Form::label('begin_date', 'Begin Date:') !!}
    <p>{!! $term->begin_date !!}</p>
</div>

<!-- End Date Field -->
<div class="form-group">
    {!! Form::label('end_date', 'End Date:') !!}
    <p>{!! $term->end_date !!}</p>
</div>

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{!! $term->created_at !!}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{!! $term->updated_at !!}</p>
</div>

<!-- Deleted At Field -->
<div class="form-group">
    {!! Form::label('deleted_at', 'Deleted At:') !!}
    <p>{!! $term->deleted_at !!}</p>
</div>

