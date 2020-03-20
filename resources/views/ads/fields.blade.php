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

<!-- Ad Location Field -->
<div class="form-group col-sm-6">
    {!! Form::label('ad_location', 'Ad Location:') !!}
    {!! Form::text('ad_location', null, ['class' => 'form-control']) !!}
</div>

<!-- English Ad Location Field -->
<div class="form-group col-sm-6">
    {!! Form::label('english_ad_location', 'English Ad Location:') !!}
    {!! Form::text('english_ad_location', null, ['class' => 'form-control']) !!}
</div>

<!-- Advertisable Type Field -->
<div class="form-group col-sm-6">
    {!! Form::label('advertisable_type', 'Advertisable Type:') !!}
    {!! Form::text('advertisable_type', null, ['class' => 'form-control']) !!}
</div>

<!-- Advertisable Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('advertisable_id', 'Advertisable Id:') !!}
    {!! Form::number('advertisable_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Offered Price Field -->
<div class="form-group col-sm-6">
    {!! Form::label('offered_price', 'Offered Price:') !!}
    {!! Form::text('offered_price', null, ['class' => 'form-control']) !!}
</div>

<!-- Phone Number Field -->
<div class="form-group col-sm-6">
    {!! Form::label('phone_number', 'Phone Number:') !!}
    {!! Form::text('phone_number', null, ['class' => 'form-control']) !!}
</div>

<!-- Description Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('description', 'Description:') !!}
    {!! Form::textarea('description', null, ['class' => 'form-control']) !!}
</div>

<!-- Is Verified Field -->
<div class="form-group col-sm-6">
    {!! Form::label('is_verified', 'Is Verified:') !!}
    <label class="checkbox-inline">
        {!! Form::hidden('is_verified', 0) !!}
        {!! Form::checkbox('is_verified', '1', null) !!}
    </label>
</div>


<!-- Is Special Field -->
<div class="form-group col-sm-6">
    {!! Form::label('is_special', 'Is Special:') !!}
    <label class="checkbox-inline">
        {!! Form::hidden('is_special', 0) !!}
        {!! Form::checkbox('is_special', '1', null) !!}
    </label>
</div>


<!-- Category Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('category_id', 'Category Id:') !!}
    {!! Form::number('category_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Ad Type Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('ad_type_id', 'Ad Type Id:') !!}
    {!! Form::number('ad_type_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Creator Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('creator_id', 'Creator Id:') !!}
    {!! Form::number('creator_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('ads.index') }}" class="btn btn-default">Cancel</a>
</div>
