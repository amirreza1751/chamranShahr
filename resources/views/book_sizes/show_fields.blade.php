<!-- Id Field -->
<div class="form-group">
    {!! Form::label('id', 'Id:') !!}
    <p>{{ $bookSize->id }}</p>
</div>

<!-- Size Name Field -->
<div class="form-group">
    {!! Form::label('size_name', 'Size Name:') !!}
    <p>{{ $bookSize->size_name }}</p>
</div>

<!-- English Size Name Field -->
<div class="form-group">
    {!! Form::label('english_size_name', 'English Size Name:') !!}
    <p>{{ $bookSize->english_size_name }}</p>
</div>

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $bookSize->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $bookSize->updated_at }}</p>
</div>

<!-- Deleted At Field -->
<div class="form-group">
    {!! Form::label('deleted_at', 'Deleted At:') !!}
    <p>{{ $bookSize->deleted_at }}</p>
</div>

