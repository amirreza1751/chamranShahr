<input name="make_notification" id="make_notification" type="hidden" value="{{false}}">
@if(isset($news)) {{--edit view--}}
    <input id="news_id" type="hidden" value="{{$news->id}}">
    @if(sizeof($news->notifications) > 0)
        <input id="has_notification" type="hidden" value="{{true}}">
    @endif
@endif


<!-- Title Field -->
<div class="form-group col-sm-6">
    {!! Form::label('title', 'عنوان:') !!}
    {!! Form::text('title', null, ['class' => 'form-control']) !!}
</div>

<!-- Creator Field -->
<div class="form-group col-sm-6">
    {!! Form::label('creator_id', 'سازنده:') !!}
    {{--    {!! Form::text('creator_id', null, ['class' => 'form-control']) !!}--}}
    {!! Form::select('creator_id', $creators, null, ['class' => 'form-control']) !!}
</div>

<!-- Link Field -->
<div class="form-group col-sm-12">
    {!! Form::label('link', 'پیوند:') !!}
    {!! Form::textarea('link', null, ['class' => 'form-control', 'rows' => 4, 'dir' => 'ltr']) !!}
</div>

<!-- Description Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('description', 'توضیحات:') !!}
    {!! Form::textarea('description', null, ['class' => 'form-control']) !!}
</div>

<!-- Path Field -->
<div class="form-group">
    <div class="form-group col-sm-12 col-lg-12">
        {!! Form::label('path', 'تصویر:') !!}
    </div>
    <div class="col-md-10">
        <input type="file" name="path" class="form-control custom-file-input"
               id="customFile">
        <label style="margin-right: 10px" class="form-control custom-file-label"
               for="customFile"></label>
    </div>
</div>

<!-- Owner Type Field -->
<div class="form-group col-sm-6">
    {!! Form::label('owner_type', 'نوع مالک:') !!}
    {{--    {!! Form::text('creator_id', null, ['class' => 'form-control']) !!}--}}
    <select class="form-control m-bot15" name="owner_type" id="owner_type">
        <option disabled selected value> -- یک گزینه انتخاب کنید -- </option>
        @if(isset($news)) // edit view
            @foreach($owner_types as $key => $value)
                @if($value == $news->owner_type)
                    <option value="{{ $value }}" selected>{{ $key }}</option>
                @else
                    <option value="{{ $value }}">{{ $key }}</option>
                @endif
            @endforeach
        @else                   // create view
            @foreach($owner_types as $key => $value)
                <option value="{{ $value }}">{{ $key }}</option>
            @endforeach
        @endif
    </select>
</div>

<script>
    jQuery(document).ready(function(){
        $('select[name="owner_type"]').on('change', function(){
            jQuery('#owner_id').empty();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            jQuery.ajax({
                url: "{{ url('/news/ajaxOwner') }}",
                method: 'get',
                data: {
                    model_name: jQuery('#owner_type').val(),
                    id: jQuery('#notice_id').val(),
                },
                success: function(data){
                    $.each(data, function(id, owner){
                        if(owner['selected']){
                            $('#owner_id').append('<option selected value="'+ owner['id'] +'">' + owner['title'] + '</option>');
                        } else {
                            $('#owner_id').append('<option value="'+ owner['id'] +'">' + owner['title'] + '</option>');
                        }
                    });
                },
                failure: function (data) {
                    console.log('failure');
                }
            });
        });
    });
</script>

<!-- Owner Field -->
<div class="form-group col-sm-6">
    {!! Form::label('owner_id', 'مالک:') !!}
    {{--    {!! Form::text('creator_id', null, ['class' => 'form-control']) !!}--}}
    <select class="form-control" name="owner_id" id="owner_id"></select>
</div>

<script>
    jQuery(document).ready(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        jQuery.ajax({
            url: "{{ url('/news/ajaxOwner') }}",
            method: 'get',
            data: {
                model_name: jQuery('#owner_type').val(),
                id: jQuery('#notice_id').val(),
            },
            success: function(data){
                $.each(data, function(id, owner){
                    if(owner['selected']){
                        $('#owner_id').append('<option selected value="'+ owner['id'] +'">' + owner['title'] + '</option>');
                    } else {
                        $('#owner_id').append('<option value="'+ owner['id'] +'">' + owner['title'] + '</option>');
                    }
                });
            },
            failure: function (data) {
                console.log('failure');
            }
        });
    });
</script>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('ذخیره', ['class' => 'btn btn-primary', 'id' => 'submit']) !!}
    <a href="{!! route('news.index') !!}" class="btn btn-default">لغو</a>
</div>

<script>
    $("#submit").click(function(){
        if(confirm("میخواهید از این اطلاعیه نوتیفیکیشن ساخته شود؟")){
            if($("#has_notification").val()){
                if(confirm("از این اطلاعیه قبلا نوتیفیکیشن ساخته شده است. مایلید ادامه دهید؟")){
                    $("#make_notification").val(true);
                }
            } else {
                $("#make_notification").val(true);
            }
        }
    });
</script>
