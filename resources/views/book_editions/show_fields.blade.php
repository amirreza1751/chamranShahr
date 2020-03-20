<!-- Id Field -->
<div class="form-group">
    {!! Form::label('id', 'Id:') !!}
    <p>{{ $bookEdition->id }}</p>
</div>

<!-- Edition Field -->
<div class="form-group">
    {!! Form::label('edition', 'Edition:') !!}
    <p>{{ $bookEdition->edition }}</p>
</div>

<!-- English Edition Field -->
<div class="form-group">
    {!! Form::label('english_edition', 'English Edition:') !!}
    <p>{{ $bookEdition->english_edition }}</p>
</div>

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $bookEdition->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $bookEdition->updated_at }}</p>
</div>

<!-- Deleted At Field -->
<div class="form-group">
    {!! Form::label('deleted_at', 'Deleted At:') !!}
    <p>{{ $bookEdition->deleted_at }}</p>
</div>

