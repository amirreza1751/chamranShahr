<!-- Id Field -->
<div class="form-group">
    {!! Form::label('id', 'Id:') !!}
    <p>{{ $book->id }}</p>
</div>

<!-- Title Field -->
<div class="form-group">
    {!! Form::label('title', 'Title:') !!}
    <p>{{ $book->title }}</p>
</div>

<!-- Edition Id Field -->
<div class="form-group">
    {!! Form::label('edition_id', 'Edition Id:') !!}
    <p>{{ $book->edition_id }}</p>
</div>

<!-- Publisher Field -->
<div class="form-group">
    {!! Form::label('publisher', 'Publisher:') !!}
    <p>{{ $book->publisher }}</p>
</div>

<!-- Publication Date Field -->
<div class="form-group">
    {!! Form::label('publication_date', 'Publication Date:') !!}
    <p>{{ $book->publication_date }}</p>
</div>

<!-- Book Length Field -->
<div class="form-group">
    {!! Form::label('book_length', 'Book Length:') !!}
    <p>{{ $book->book_length }}</p>
</div>

<!-- Language Id Field -->
<div class="form-group">
    {!! Form::label('language_id', 'Language Id:') !!}
    <p>{{ $book->language_id }}</p>
</div>

<!-- Isbn Field -->
<div class="form-group">
    {!! Form::label('isbn', 'Isbn:') !!}
    <p>{{ $book->isbn }}</p>
</div>

<!-- Author Field -->
<div class="form-group">
    {!! Form::label('author', 'Author:') !!}
    <p>{{ $book->author }}</p>
</div>

<!-- Translator Field -->
<div class="form-group">
    {!! Form::label('translator', 'Translator:') !!}
    <p>{{ $book->translator }}</p>
</div>

<!-- Price Field -->
<div class="form-group">
    {!! Form::label('price', 'Price:') !!}
    <p>{{ $book->price }}</p>
</div>

<!-- Size Id Field -->
<div class="form-group">
    {!! Form::label('size_id', 'Size Id:') !!}
    <p>{{ $book->size_id }}</p>
</div>

<!-- Is Grayscale Field -->
<div class="form-group">
    {!! Form::label('is_grayscale', 'Is Grayscale:') !!}
    <p>{{ $book->is_grayscale }}</p>
</div>

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $book->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $book->updated_at }}</p>
</div>

<!-- Deleted At Field -->
<div class="form-group">
    {!! Form::label('deleted_at', 'Deleted At:') !!}
    <p>{{ $book->deleted_at }}</p>
</div>

