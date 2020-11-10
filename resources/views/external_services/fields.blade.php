@if(isset($external_service)) {{--edit view--}}
    <input id="external_service_id" type="hidden" value="{{$external_service->id}}">
@endif

<!-- Title Field -->
<div class="form-group col-sm-6">
    {!! Form::label('title', 'عنوان:') !!} <span class="text-danger text-small">الزامی</span>
    {!! Form::text('title', null, ['class' => 'form-control']) !!}
</div>

<!-- English Title Field -->
<div class="form-group col-sm-6">
    {!! Form::label('english_title', 'عنوان انگلیسی:') !!}
    {!! Form::text('english_title', null, ['class' => 'form-control']) !!}
</div>

<!-- Url Field -->
<div class="form-group col-sm-12">
    {!! Form::label('url', 'پیوند:') !!} <span class="text-danger text-small">الزامی</span>
    {!! Form::text('url', null, ['class' => 'form-control', 'dir' => 'ltr']) !!}
</div>

<!-- Type Field -->
<div class="form-group col-sm-6">
    {!! Form::label('type_id', 'نوع:') !!} <span class="text-danger text-small">الزامی</span>
    {!! Form::select('type_id', $external_service_types, null, ['class' => 'form-control']) !!}
</div>

<!-- Content Type Field -->
<div class="form-group col-sm-6">
    {!! Form::label('content_type', 'نوع محتوا:') !!} <span class="text-danger text-small">الزامی</span>
    {{--    {!! Form::select('content_type', $content_types, null, ['class' => 'form-control']) !!}--}}
    <select class="form-control m-bot15" name="content_type" id="content_type">
        <option disabled selected value> -- یک گزینه انتخاب کنید -- </option>
        @if(old('content_type')) // edit view
            @foreach($content_types as $key => $value)
                @if($value == old('content_type'))
                    <option value="{{ $value }}" selected>{{ $key }}</option>
                @else
                    <option value="{{ $value }}">{{ $key }}</option>
                @endif
            @endforeach
        @elseif(isset($external_service)) // edit view
            @foreach($content_types as $key => $value)
                @if($value == $external_service->content_type)
                    <option value="{{ $value }}" selected>{{ $key }}</option>
                @else
                    <option value="{{ $value }}">{{ $key }}</option>
                @endif
            @endforeach
        @else                   // create view
            @foreach($content_types as $key => $value)
                <option value="{{ $value }}">{{ $key }}</option>
            @endforeach
        @endif
    </select>
</div>

<!-- Owner Type Field -->
<div class="form-group col-sm-6">
    {!! Form::label('owner_type', 'نوع مالک:') !!} <span class="text-danger text-small">الزامی</span>
    <select class="form-control m-bot15" name="owner_type" id="owner_type">
        <option disabled selected value> -- یک گزینه انتخاب کنید -- </option>
        @if(old('owner_type')) // edit view
            @foreach($owner_types as $key => $value)
                @if($value == old('owner_type'))
                    <option value="{{ $value }}" selected>{{ $key }}</option>
                @else
                    <option value="{{ $value }}">{{ $key }}</option>
                @endif
            @endforeach
        @elseif(isset($external_service)) // edit view
            @foreach($owner_types as $key => $value)
                @if($value == $external_service->owner_type)
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
                url: "{{ url('/externalServices/ajaxOwner') }}",
                method: 'get',
                data: {
                    model_name: jQuery('#owner_type').val(),
                    id: jQuery('#external_service_id').val(),
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
    {!! Form::label('owner_id', 'مالک:') !!} <span class="text-danger text-small">الزامی</span>
    <select class="form-control" name="owner_id" id="owner_id"></select>
</div>

<script>
    jQuery(document).ready(function(){
        jQuery('#owner_id').empty();
        var old_owner_id = '{{ old('owner_id') }}';
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        jQuery.ajax({
            url: "{{ url('/externalServices/ajaxOwner') }}",
            method: 'get',
            data: {
                model_name: jQuery('#owner_type').val(),
                id: jQuery('#external_service_id').val(),
            },
            success: function(data){
                $.each(data, function(id, owner){
                    if(old_owner_id && old_owner_id == owner['id']){
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
    {!! Form::submit('ذخیره', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('externalServices.index') !!}" class="btn btn-default">لغو</a>
</div>
