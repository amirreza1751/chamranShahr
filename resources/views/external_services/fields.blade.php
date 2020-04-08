@if(isset($external_service)) {{--edit view--}}
    <input id="external_service_id" type="hidden" value="{{$external_service->id}}">
@endif

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

<!-- Url Field -->
<div class="form-group col-sm-12">
    {!! Form::label('url', 'Url:') !!}
    {!! Form::text('url', null, ['class' => 'form-control']) !!}
</div>

<!-- Type Field -->
<div class="form-group col-sm-6">
    {!! Form::label('type_id', 'Type:') !!}
    {!! Form::select('type_id', $external_service_types, null, ['class' => 'form-control']) !!}
</div>

<!-- Content Type Field -->
<div class="form-group col-sm-6">
    {!! Form::label('content_type', 'Content Type:') !!}
    {{--    {!! Form::select('content_type', $content_types, null, ['class' => 'form-control']) !!}--}}
    <select class="form-control m-bot15" name="content_type" id="content_type">
        <option disabled selected value> -- select an option -- </option>
        @if(isset($external_service)) // edit view
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
    {!! Form::label('owner_type', 'Owner Type:') !!}
    <select class="form-control m-bot15" name="owner_type" id="owner_type">
        <option disabled selected value> -- select an option -- </option>
        @if(isset($external_service)) // edit view
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

<script src="http://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous">
</script>
<script>
    jQuery(document).ready(function(){
        $('select[name="owner_type"]').on('click', function(){
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
    {!! Form::label('owner_id', 'Owner:') !!}
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
</script>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('externalServices.index') !!}" class="btn btn-default">Cancel</a>
</div>
