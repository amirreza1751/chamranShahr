<!-- Id Field -->
<div class="form-group">
    {!! Form::label('id', 'Id:') !!}
    <p>{!! $externalService->id !!}</p>
</div>

<!-- Title Field -->
<div class="form-group">
    {!! Form::label('title', 'Title:') !!}
    <p>{!! $externalService->title !!}</p>
</div>

<!-- English Title Field -->
<div class="form-group">
    {!! Form::label('english_title', 'English Title:') !!}
    <p>{!! $externalService->english_title !!}</p>
</div>

<!-- Url Field -->
<div class="form-group">
    {!! Form::label('url', 'Url:') !!}
    <p>{!! $externalService->url !!}</p>
</div>

<!-- Type Id Field -->
<div class="form-group">
    {!! Form::label('type_id', 'Type Id:') !!}
    <p>{!! $externalService->type_id !!}</p>
</div>

<!-- Content Type Field -->
<div class="form-group">
    {!! Form::label('content_type', 'Content Type:') !!}
    <p>{!! $externalService->content_type !!}</p>
</div>

<!-- Owner Type Field -->
<div class="form-group">
    {!! Form::label('owner_type', 'Owner Type:') !!}
    <p>{!! $externalService->owner_type !!}</p>
</div>

<!-- Owner Id Field -->
<div class="form-group">
    {!! Form::label('owner_id', 'Owner Id:') !!}
    <p>{!! $externalService->owner_id !!}</p>
</div>

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{!! $externalService->created_at !!}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{!! $externalService->updated_at !!}</p>
</div>

<!-- Deleted At Field -->
<div class="form-group">
    {!! Form::label('deleted_at', 'Deleted At:') !!}
    <p>{!! $externalService->deleted_at !!}</p>
</div>

