<input name="make_notification" id="make_notification" type="hidden" value="{{false}}">
@if(isset($notice)) {{--edit view--}}
    <input id="notice_id" type="hidden" value="{{$notice->id}}">
    @if(sizeof($notice->notifications) > 0)
        <input id="has_notification" type="hidden" value="{{true}}">
    @endif
@endif


<!-- Title Field -->
<div class="form-group col-sm-6">
    {!! Form::label('title', 'Title:') !!}
    {!! Form::text('title', null, ['class' => 'form-control']) !!}
</div>

<!-- Link Field -->
<div class="form-group col-sm-6">
    {!! Form::label('link', 'Link:') !!}
    {!! Form::text('link', null, ['class' => 'form-control']) !!}
</div>

<!-- Path Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('path', 'Path:') !!}
    {!! Form::textarea('path', null, ['class' => 'form-control']) !!}
</div>

<!-- Description Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('description', 'Description:') !!}
    {!! Form::textarea('description', null, ['class' => 'form-control']) !!}
</div>

<!-- Author Field -->
<div class="form-group col-sm-6">
    {!! Form::label('author', 'Author:') !!}
    {!! Form::text('author', null, ['class' => 'form-control']) !!}
</div>

<!-- Creator Field -->
<div class="form-group col-sm-6">
    {!! Form::label('creator_id', 'Creator:') !!}
    {{--    {!! Form::text('creator_id', null, ['class' => 'form-control']) !!}--}}
    {!! Form::select('creator_id', $creators, null, ['class' => 'form-control']) !!}
</div>

<!-- Owner Type Field -->
<div class="form-group col-sm-6">
    {!! Form::label('owner_type', 'Owner Type:') !!}
    {{--    {!! Form::text('creator_id', null, ['class' => 'form-control']) !!}--}}
    <select class="form-control m-bot15" name="owner_type" id="owner_type">
        <option disabled selected value> -- select an option -- </option>
        @if(isset($notice)) // edit view
            @foreach($owner_types as $key => $value)
                @if($value == $notice->owner_type)
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
                url: "{{ url('/notices/ajaxOwner') }}",
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
    {!! Form::label('owner_id', 'Owner:') !!}
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
                url: "{{ url('/notices/ajaxOwner') }}",
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
{{--    {!! Form::submit('Save', ['class' => 'btn btn-primary', 'onclick' => "ConfirmDialog('Are you sure')"]) !!}--}}
    {!! Form::submit('Save', ['class' => 'btn btn-primary', 'id' => 'submit']) !!}

    <a href="{!! route('notices.index') !!}" class="btn btn-default">Cancel</a>
</div>

<script>
    $("#submit").click(function(){
        if(confirm("do you want make a notification too?")){
            if($("#has_notification").val()){
                if(confirm("this notice has notifications before, create anathor one?!")){
                    $("#make_notification").val(true);
                }
            } else {
                $("#make_notification").val(true);
            }
        }
    });
</script>
