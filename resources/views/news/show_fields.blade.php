<div class="col-sm-4">
    <div class="card" style="margin-bottom: 1rem">
        <img class="card-img-top" src="{{ $news->absolute_path }}" alt="تصویر خبر">
        <div class="card-body">
            {{--            <h4 class="card-title vazir-font-fd">{{ $user->first_name . ' ' . $user->last_name }}</h4>--}}
            {{--            <p class="card-text">نوع کاربری: </p>--}}
            {{--            <p class="card-text">جنسیت: @if(isset($user->gender->title)) {{ $user->gender->title }} @endif</p>--}}
            <a href="{{ $news->absolute_path }}" target="_blank" class="btn btn-primary">بزرگنمایی</a>
        </div>
    </div>
</div>

<div class="col-sm-8">
    <!-- Id Field -->
    <div class="form-group">
        {!! Form::label('id', 'شناسه:') !!}
        <p>{!! $news->id !!}</p>
    </div>

    <!-- Title Field -->
    <div class="form-group">
        {!! Form::label('title', 'عنوان:') !!}
        <p>{!! $news->title !!}</p>
    </div>

    <!-- Link Field -->
    <div class="form-group">
        {!! Form::label('link', 'پیوند:') !!}
        <p><a href="{!! $news->link !!}" target="_blank">بازدید</a></p>
    </div>

    <!-- Description Field -->
    <div class="form-group">
        {!! Form::label('description', 'توضیحات:') !!}
        <p class="text-justify">{!! $news->description !!}</p>
    </div>

    <!-- Created At Field -->
    <div class="form-group">
        {!! Form::label('created_at', 'ساخته شده در:') !!}
        <p>
            @if(isset($news->created_at))
                {{ Morilog\Jalali\Jalalian::fromDateTime($news->created_at)->format('%A, %d %B %Y') }} ساعت {{ Morilog\Jalali\Jalalian::fromDateTime($news->created_at)->format('h:m A') }}
            @endif
        </p>
    </div>

    <!-- Updated At Field -->
    <div class="form-group">
        {!! Form::label('updated_at', 'آخرین ویرایش:') !!}
        <p>
            @if(isset($news->updated_at))
                {{ Morilog\Jalali\Jalalian::fromDateTime($news->updated_at)->format('%A, %d %B %Y') }} ساعت {{ Morilog\Jalali\Jalalian::fromDateTime($news->updated_at)->format('h:m A') }}
            @endif
        </p>
    </div>
</div>

