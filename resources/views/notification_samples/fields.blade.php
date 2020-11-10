{{--@if(isset($notificationSample->notifier_type)) --}}{{--reditect view--}}
{{--    <input id="type" type="hidden" value="{{$notificationSample->notifier_type}}">--}}
{{--@endif--}}

{{--@if(isset($notificationSample->notifier_id)) --}}{{--reditect view--}}
{{--    <input id="id" type="hidden" value="{{$notificationSample->notifier_id}}">--}}
{{--@endif--}}

<!-- Title Field -->
<div class="form-group col-sm-6">
    {!! Form::label('title', 'عنوان:') !!} <span class="text-danger text-small">الزامی</span>
    {!! Form::text('title', null, ['class' => 'form-control']) !!}
</div>

<!-- Type Field -->
<div class="form-group col-sm-6">
    {!! Form::label('type', 'نوع:') !!} <span class="text-danger text-small">الزامی</span>
    <select class="form-control m-bot15" name="type" id="type">
        <option disabled selected value> -- انتخاب کنید -- </option>
        @if(old('type'))
            @foreach($notification_types as $key => $value)
                @if($key == old('type'))
                    <option value="{{ $key }}" selected>{{ $value }}</option>
                @else
                    <option value="{{ $key }}">{{ $value }}</option>
                @endif
            @endforeach
        @elseif($notificationSample->type)
            @foreach($notification_types as $key => $value)
                @if($key == $notificationSample->type)
                    <option value="{{ $key }}" selected>{{ $value }}</option>
                @else
                    <option value="{{ $key }}">{{ $value }}</option>
                @endif
            @endforeach
        @else
            @foreach($notification_types as $key => $value)
                <option value="{{ $key }}">{{ $value }}</option>
            @endforeach
        @endif
    </select>
</div>

<!-- Brief Description Field -->
<div class="form-group col-sm-12">
    {!! Form::label('brief_description', 'توضیحات:') !!} <span class="text-danger text-small">الزامی</span>
    {!! Form::textarea('brief_description', null, ['class' => 'form-control', 'rows' => 2, 'maxlength' => 145]) !!}
</div>

{{--<!-- Notifier Type Field -->--}}
{{--<div class="form-group col-sm-6">--}}
{{--    {!! Form::label('notifier_type', 'دسته‌ی منبع:') !!}--}}
{{--    <select class="form-control m-bot15" name="notifier_type" id="notifier_type">--}}
{{--        <option disabled selected value> -- انتخاب کنید -- </option>--}}
{{--        @foreach($notifiers as $key => $value)--}}
{{--            @if($value == $notificationSample->notifier_type)--}}
{{--                <option value="{{ $value }}" selected>{{ $key }}</option>--}}
{{--            @else--}}
{{--                <option value="{{ $value }}">{{ $key }}</option>--}}
{{--            @endif--}}
{{--        @endforeach--}}
{{--    </select>--}}
{{--</div>--}}

{{--<script src="http://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous">--}}
{{--</script>--}}
{{--<script>--}}
{{--    jQuery(document).ready(function(){--}}
{{--        $('select[name="notifier_type"]').on('change', function(){--}}
{{--            jQuery('#notifier_id').empty();--}}
{{--            $('#notifier_id').append('<option disabled selected value> -- انتخاب کنید -- </option>');--}}
{{--            $.ajaxSetup({--}}
{{--                headers: {--}}
{{--                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')--}}
{{--                }--}}
{{--            });--}}
{{--            jQuery.ajax({--}}
{{--                url: "{{ url('/notifications/ajaxNotifier') }}",--}}
{{--                method: 'get',--}}
{{--                data: {--}}
{{--                    model_name: jQuery('#notifier_type').val(),--}}
{{--                    notifier_type: jQuery('#type').val(),--}}
{{--                    notifier_id: jQuery('#id').val(),--}}
{{--                },--}}
{{--                success: function(data){--}}
{{--                    console.log(data);--}}
{{--                    $.each(data, function(id, notifier){--}}
{{--                        if(notifier['selected']){--}}
{{--                            console.log('selected');--}}
{{--                            $('#notifier_id').append('<option selected value="'+ notifier['id'] +'">' + notifier['title'] + '</option>');--}}
{{--                        } else {--}}
{{--                            $('#notifier_id').append('<option value="'+ notifier['id'] +'">' + notifier['title'] + '</option>');--}}
{{--                        }--}}
{{--                    });--}}
{{--                },--}}
{{--                failure: function (data) {--}}
{{--                    console.log('failure');--}}
{{--                }--}}
{{--            });--}}
{{--        });--}}
{{--    });--}}
{{--</script>--}}

{{--<!-- Notifier Id Field -->--}}
{{--<div class="form-group col-sm-6">--}}
{{--    {!! Form::label('notifier_id', 'منبع:') !!}--}}
{{--    <select class="form-control m-bot15" name="notifier_id" id="notifier_id">--}}
{{--        <option disabled selected value> -- انتخاب کنید -- </option>--}}
{{--        @if(isset($notifier)) // edit view--}}
{{--        <option value="{{ $notifier->id }}" selected>{{ $notifier->title }}</option>--}}
{{--        @endif--}}
{{--    </select>--}}
{{--</div>--}}

<!-- Deadline Field -->
<div class="form-group col-sm-6">
    {!! Form::label('deadline', 'تاریخ انقضا:') !!} <span class="text-danger text-small">الزامی</span>
{{--    {!! Form::date('deadline', null, ['class' => 'form-control','id'=>'deadline']) !!}--}}
    <input autocomplete="off" class="form-control" dir="ltr" type="text" value="{{old('deadline_pd')}}" placeholder="{{$deadline_pd}}" id="deadline_pd" name="deadline_pd"/>
    <input type="hidden" id="deadline" name="deadline" value="{{old('deadline')}}"/>
</div>


<script>
    function convert(str){
        var persianNumbers = [/۰/g, /۱/g, /۲/g, /۳/g, /۴/g, /۵/g, /۶/g, /۷/g, /۸/g, /۹/g], englishNumbers  = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9];
        if(typeof str === 'string')
        {
            for(var i=0; i<10; i++)
            {
                str = str.replace(persianNumbers[i], i).replace(englishNumbers[i], i);
            }
        }
        return str;
    }

    jQuery(document).ready(function () {

            $('#submit').on('click', function () {
                var deadline_pd = $('#deadline_pd');
                $('#deadline').val(convert(deadline_pd.val()));
            });


            $('#deadline_pd').persianDatepicker({
                observer: true,
                format: 'YYYY/MM/DD',
                initialValue: false,
            });
        });
</script>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('ذخیره', ['class' => 'btn btn-primary', 'id' => 'submit']) !!}
    <a href="{{ route('notificationSamples.index') }}" class="btn btn-default">لغو</a>
</div>
