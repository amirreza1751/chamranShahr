<!-- Title Field -->
<div class="form-group col-sm-6">
    {!! Form::label('title', 'Title:') !!}
    {!! Form::text('title', null, ['class' => 'form-control']) !!}
</div>

<!-- Edition Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('edition_id', 'Edition Id:') !!}
    {!! Form::number('edition_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Publisher Field -->
<div class="form-group col-sm-6">
    {!! Form::label('publisher', 'Publisher:') !!}
    {!! Form::text('publisher', null, ['class' => 'form-control']) !!}
</div>

<!-- Publication Date Field -->
<div class="form-group col-sm-6">
    {!! Form::label('publication_date', 'Publication Date:') !!}
    {!! Form::date('publication_date', null, ['class' => 'form-control','id'=>'publication_date']) !!}
</div>

@section('scripts')
    <script type="text/javascript">
        $('#publication_date').datetimepicker({
            format: 'YYYY-MM-DD HH:mm:ss',
            useCurrent: false
        })
    </script>
@endsection

<!-- Book Length Field -->
<div class="form-group col-sm-6">
    {!! Form::label('book_length', 'Book Length:') !!}
    {!! Form::number('book_length', null, ['class' => 'form-control']) !!}
</div>

<!-- Language Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('language_id', 'Language Id:') !!}
    {!! Form::number('language_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Isbn Field -->
<div class="form-group col-sm-6">
    {!! Form::label('isbn', 'Isbn:') !!}
    {!! Form::text('isbn', null, ['class' => 'form-control']) !!}
</div>

<!-- Author Field -->
<div class="form-group col-sm-6">
    {!! Form::label('author', 'Author:') !!}
    {!! Form::text('author', null, ['class' => 'form-control']) !!}
</div>

<!-- Translator Field -->
<div class="form-group col-sm-6">
    {!! Form::label('translator', 'Translator:') !!}
    {!! Form::text('translator', null, ['class' => 'form-control']) !!}
</div>

<!-- Price Field -->
<div class="form-group col-sm-6">
    {!! Form::label('price', 'Price:') !!}
    {!! Form::text('price', null, ['class' => 'form-control']) !!}
</div>

<!-- Size Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('size_id', 'Size Id:') !!}
    {!! Form::number('size_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Is Grayscale Field -->
<div class="form-group col-sm-6">
    {!! Form::label('is_grayscale', 'Is Grayscale:') !!}
    <label class="checkbox-inline">
        {!! Form::hidden('is_grayscale', 0) !!}
        {!! Form::checkbox('is_grayscale', '1', null) !!}
    </label>
</div>


<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('books.index') }}" class="btn btn-default">Cancel</a>
</div>
