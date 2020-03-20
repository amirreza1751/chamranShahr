<!-- Ad Type Title Field -->
<div class="form-group col-sm-6">
    {!! Form::label('ad_type_title', 'Ad Type Title:') !!}
    {!! Form::text('ad_type_title', null, ['class' => 'form-control']) !!}
</div>

<!-- English Ad Type Title Field -->
<div class="form-group col-sm-6">
    {!! Form::label('english_ad_type_title', 'English Ad Type Title:') !!}
    {!! Form::text('english_ad_type_title', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('adTypes.index') }}" class="btn btn-default">Cancel</a>
</div>
