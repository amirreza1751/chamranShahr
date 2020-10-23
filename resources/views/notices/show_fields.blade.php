<div class="col-sm-4">
    <div class="card" style="margin-bottom: 1rem">
        <img class="card-img-top" src="{{ $notice->absolute_path }}" alt="تصویر اطلاعیه">
        <div class="card-body">
{{--            <h4 class="card-title vazir-font-fd">{{ $user->first_name . ' ' . $user->last_name }}</h4>--}}
{{--            <p class="card-text">نوع کاربری: </p>--}}
{{--            <p class="card-text">جنسیت: @if(isset($user->gender->title)) {{ $user->gender->title }} @endif</p>--}}
            <a href="{{ $notice->absolute_path }}" target="_blank" class="btn btn-primary">بزرگنمایی</a>
        </div>
    </div>
</div>

<div class="col-sm-8">
    <!-- Id Field -->
    <div class="form-group">
        {!! Form::label('id', 'شناسه:') !!}
        <p>{!! $notice->id !!}</p>
    </div>

    <!-- Title Field -->
    <div class="form-group">
        {!! Form::label('title', 'عنوان:') !!}
        <p>{!! $notice->title !!}</p>
    </div>

    <!-- Link Field -->
    <div class="form-group">
        {!! Form::label('link', 'پیوند:') !!}
        <p><a href="{!! $notice->link !!}" target="_blank">بازدید</a></p>
    </div>

<!-- Description Field -->
    <div class="form-group">
        {!! Form::label('description', 'توضیحات:') !!}
        <p class="text-justify">{!! $notice->description !!}</p>
    </div>

    <!-- Author Field -->
    <div class="form-group">
        {!! Form::label('author', 'نویسنده (منبع):') !!}
        <p>{!! $notice->author !!}</p>
    </div>

    <!-- Created At Field -->
    <div class="form-group">
        {!! Form::label('created_at', 'ساخته شده در:') !!}
        <p>
            @if(isset($notice->created_at))
                {{ Morilog\Jalali\Jalalian::fromDateTime($notice->created_at)->format('%A, %d %B %Y') }} ساعت {{ Morilog\Jalali\Jalalian::fromDateTime($notice->created_at)->format('h:m A') }}
            @endif
        </p>
    </div>

    <!-- Updated At Field -->
    <div class="form-group">
        {!! Form::label('updated_at', 'آخرین ویرایش:') !!}
        <p>
            @if(isset($notice->updated_at))
                {{ Morilog\Jalali\Jalalian::fromDateTime($notice->updated_at)->format('%A, %d %B %Y') }} ساعت {{ Morilog\Jalali\Jalalian::fromDateTime($notice->updated_at)->format('h:m A') }}
            @endif
        </p>
    </div>

    {{--<!-- Deleted At Field -->--}}
    {{--<div class="form-group">--}}
    {{--    {!! Form::label('deleted_at', 'Deleted At:') !!}--}}
    {{--    <p>{!! $notice->deleted_at !!}</p>--}}
    {{--</div>--}}

</div>
