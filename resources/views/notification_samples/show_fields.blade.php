<div class="col-sm-4">
    <div class="card" style="margin-bottom: 1rem">
        <img class="card-img-top" src="{{ $notificationSample->absolute_path }}" alt="تصویر اطلاعیه">
        <div class="card-body">
            <a href="{{ $notificationSample->absolute_path }}" target="_blank" class="btn btn-primary">بزرگنمایی</a>
        </div>
    </div>
</div>

<div class="col-sm-8">
    <!-- Id Field -->
    <div class="form-group">
        {!! Form::label('id', 'شناسه:') !!}
        <p>{{ $notificationSample->id }}</p>
    </div>

    <!-- Title Field -->
    <div class="form-group">
        {!! Form::label('title', 'عنوان:') !!}
        <p>{{ $notificationSample->title }}</p>
    </div>

    <!-- Brief Description Field -->
    <div class="form-group">
        {!! Form::label('brief_description', 'توضیحات:') !!}
        <p>{{ $notificationSample->brief_description }}</p>
    </div>

    <!-- Type Field -->
    <div class="form-group">
        {!! Form::label('type', 'نوع:') !!}
        <p>{{ $notification_types[$notificationSample->type] }}</p>
    </div>

    <!-- Notifier Type Field -->
    <div class="form-group">
        {!! Form::label('notifier_type', 'نوع منبع:') !!}
        <p>{{ $notificationSample->notifier_type }}</p>
    </div>

    <!-- Notifier Id Field -->
    <div class="form-group">
        {!! Form::label('notifier_id', 'شناسه‌ی منبع:') !!}
        <p>{{ $notificationSample->notifier_id }} <a href="{!! route(app($notificationSample->notifier_type)->getTable() . '.show', ['id' => $notificationSample->notifier_id]) !!}" class=' btn-success btn-xs'>مشاهده</a></p>
    </div>

    <!-- Deadline Field -->
    <div class="form-group">
        {!! Form::label('deadline', 'تاریخ انقضاء:') !!}
        <p>
            @if (isset($notificationSample->deadline))
                {{ Morilog\Jalali\Jalalian::fromDateTime($notificationSample->deadline)->format('%A, %d %B %Y') }}
            @endif
        </p>
    </div>

    <!-- Created At Field -->
    <div class="form-group">
        {!! Form::label('created_at', 'ساخته شده در:') !!}
        <p>
            @if(isset($notificationSample->created_at))
                {{ Morilog\Jalali\Jalalian::fromDateTime($notificationSample->created_at)->format('%A, %d %B %Y') }} ساعت {{ Morilog\Jalali\Jalalian::fromDateTime($notificationSample->created_at)->format('h:m A') }}
            @endif
        </p>
    </div>

    <!-- Updated At Field -->
    <div class="form-group">
        {!! Form::label('updated_at', 'آخرین ویرایش:') !!}
        <p>
            @if(isset($notificationSample->updated_at))
                {{ Morilog\Jalali\Jalalian::fromDateTime($notificationSample->updated_at)->format('%A, %d %B %Y') }} ساعت {{ Morilog\Jalali\Jalalian::fromDateTime($notificationSample->updated_at)->format('h:m A') }}
            @endif
        </p>
    </div>

    <!-- Deleted At Field -->
{{--    <div class="form-group">--}}
{{--        {!! Form::label('deleted_at', 'Deleted At:') !!}--}}
{{--        <p>{{ $notificationSample->deleted_at }}</p>--}}
{{--    </div>--}}
</div>

