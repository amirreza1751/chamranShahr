<!-- Size Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('size_name', 'Size Name:') !!}
    {!! Form::text('size_name', null, ['class' => 'form-control']) !!}
</div>

<!-- English Size Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('english_size_name', 'English Size Name:') !!}
    {!! Form::text('english_size_name', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('bookSizes.index') }}" class="btn btn-default">Cancel</a>
</div>
