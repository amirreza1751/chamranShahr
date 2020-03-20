<!-- Id Field -->
<div class="form-group">
    {!! Form::label('id', 'Id:') !!}
    <p>{{ $adType->id }}</p>
</div>

<!-- Ad Type Title Field -->
<div class="form-group">
    {!! Form::label('ad_type_title', 'Ad Type Title:') !!}
    <p>{{ $adType->ad_type_title }}</p>
</div>

<!-- English Ad Type Title Field -->
<div class="form-group">
    {!! Form::label('english_ad_type_title', 'English Ad Type Title:') !!}
    <p>{{ $adType->english_ad_type_title }}</p>
</div>

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $adType->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $adType->updated_at }}</p>
</div>

<!-- Deleted At Field -->
<div class="form-group">
    {!! Form::label('deleted_at', 'Deleted At:') !!}
    <p>{{ $adType->deleted_at }}</p>
</div>

