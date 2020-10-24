<!-- Id Field -->
<div class="form-group">
    {!! Form::label('id', 'شناسه:') !!}
    <p>{!! $externalService->id !!}</p>
</div>

<!-- Title Field -->
<div class="form-group">
    {!! Form::label('title', 'عنوان:') !!}
    <p>{!! $externalService->title !!}</p>
</div>

<!-- English Title Field -->
<div class="form-group">
    {!! Form::label('english_title', 'عنوان انگلیسی:') !!}
    <p>{!! $externalService->english_title !!}</p>
</div>

<!-- Url Field -->
<div class="form-group">
    {!! Form::label('url', 'آدرس:') !!}
    <p><a href="{!! $externalService->url !!}" target="_blank">پیوند</a></p>
</div>

<!-- Type Id Field -->
<div class="form-group">
    {!! Form::label('type_id', 'نوع:') !!}
    <p>{!! $externalService->type->title !!}</p>
</div>

<!-- Content Type Field -->
<div class="form-group">
    {!! Form::label('content_type', 'نوع محتوا:') !!}
    <p>{!! $externalService->content_type !!}</p>
</div>

<!-- Owner Type Field -->
<div class="form-group">
    {!! Form::label('owner_type', 'نوع مالک:') !!}
    <p>{!! $externalService->owner_type !!}</p>
</div>

<!-- Owner Id Field -->
<div class="form-group">
    {!! Form::label('owner_id', 'مالک:') !!}
    <p>{!! $externalService->owner->title !!}</p>
</div>

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'ساخته شده در:') !!}
    <p>
        @if(isset($externalService->updated_at))
            {{ Morilog\Jalali\Jalalian::fromDateTime($externalService->created_at)->format('%A, %d %B %Y') }} ساعت {{ Morilog\Jalali\Jalalian::fromDateTime($externalService->created_at)->format('h:m A') }}
        @endif
    </p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'آخرین ویرایش:') !!}
    <p>
        @if(isset($externalService->updated_at))
            {{ Morilog\Jalali\Jalalian::fromDateTime($externalService->updated_at)->format('%A, %d %B %Y') }} ساعت {{ Morilog\Jalali\Jalalian::fromDateTime($externalService->updated_at)->format('h:m A') }}
        @endif
    </p>
</div>

<!-- Deleted At Field -->
<div class="form-group">
    {!! Form::label('deleted_at', 'زمان حذف:') !!}
    <p>
        @if(isset($externalService->deleted_at))
            {{ Morilog\Jalali\Jalalian::fromDateTime($externalService->deleted_at)->format('%A, %d %B') }} ساعت {{ Morilog\Jalali\Jalalian::fromDateTime($externalService->deleted_at)->format('h:m A') }}
        @endif
    </p>
</div>

