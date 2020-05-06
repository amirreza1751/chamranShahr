@if(isset($manage_history)) {{--edit view--}}
    <input id="manage_history_id" type="hidden" value="{{$manage_history->id}}">
@endif

<!-- Manager Field -->
<div class="form-group col-sm-6">
    {!! Form::label('manager_id', 'Manager:') !!}
    <select class="form-control m-bot15" name="manager_id" id="manager_id">
        <option disabled selected value> -- select an option -- </option>
        @if(isset($manage_history)) // edit view
            @foreach($users as $key => $value)
                @if($value == $manage_history->manager_id)
                    <option value="{{ $value }}" selected>{{ $key }}</option>
                @else
                    <option value="{{ $value }}">{{ $key }}</option>
                @endif
            @endforeach
        @else                   // create view
            @foreach($users as $key => $value)
                <option value="{{ $value }}">{{ $key }}</option>
            @endforeach
        @endif
    </select>
</div>

<!-- Managed Field -->
<div class="form-group col-sm-6">
    {!! Form::label('managed_type', 'Manage Type:') !!}
    {{--    {!! Form::text('creator_id', null, ['class' => 'form-control']) !!}--}}
    <select class="form-control m-bot15" name="managed_type" id="managed_type">
        <option disabled selected value> -- select an option -- </option>
        @if(isset($notice)) // edit view
            @foreach($managed_types as $key => $value)
                @if($value == $managed_types->managed_type)
                    <option value="{{ $value }}" selected>{{ $key }}</option>
                @else
                    <option value="{{ $value }}">{{ $key }}</option>
                @endif
            @endforeach
        @else                   // create view
            @foreach($managed_types as $key => $value)
                <option value="{{ $value }}">{{ $key }}</option>
            @endforeach
        @endif
    </select>
</div>

<script>
    jQuery(document).ready(function(){
        $('select[name="managed_type"]').on('click', function(){
            jQuery('#managed_id').empty();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            jQuery.ajax({
                url: "{{ url('/manageHistories/ajaxManaged') }}",
                method: 'get',
                data: {
                    model_name: jQuery('#managed_type').val(),
                    id: jQuery('#manage_history_id').val(),
                },
                success: function(data){
                    console.log(data);
                    $.each(data, function(id, managed){
                        if(managed['selected']){
                            $('#managed_id').append('<option selected value="'+ managed['id'] +'">' + managed['title'] + '</option>');
                        } else {
                            $('#managed_id').append('<option value="'+ managed['id'] +'">' + managed['title'] + '</option>');
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
    {!! Form::label('managed_id', 'Managed:') !!}
    {{--    {!! Form::text('creator_id', null, ['class' => 'form-control']) !!}--}}
    <select class="form-control" name="managed_id" id="managed_id"></select>
</div>

<script>
    jQuery(document).ready(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        jQuery.ajax({
            url: "{{ url('/manageHistories/ajaxManaged') }}",
            method: 'get',
            data: {
                model_name: jQuery('#managed_type').val(),
                id: jQuery('#manage_history_id').val(),
            },
            success: function(data){
                $.each(data, function(id, owner){
                    if(owner['selected']){
                        $('#managed_id').append('<option selected value="'+ owner['id'] +'">' + owner['title'] + '</option>');
                    } else {
                        $('#managed_id').append('<option value="'+ owner['id'] +'">' + owner['title'] + '</option>');
                    }
                });
            },
            failure: function (data) {
                console.log('failure');
                console.log(data);
            }
        });
    });
</script>

<!-- Begin Date Field -->
<div class="form-group col-sm-6">
    {!! Form::label('begin_date', 'Begin Date:') !!}
    {!! Form::date('begin_date', null, ['class' => 'form-control','id'=>'begin_date']) !!}
</div>

@section('scripts')
    <script type="text/javascript">

{{--        @if(!isset($manage_history))--}}
{{--            jQuery(document).ready(function(){--}}
{{--                alert('hello');--}}
{{--                $('#begin_date').datepicker('setDate', new Date());--}}
{{--            });--}}
{{--        @endif--}}

        $('#begin_date').timestamppicker({
            format: 'YYYY-MM-DD HH:mm:ss',
            useCurrent: false
        })
    </script>
@endsection

<!-- End Date Field -->
<div class="form-group col-sm-6">
    {!! Form::label('end_date', 'End Date:') !!}
    {!! Form::date('end_date', null, ['class' => 'form-control','id'=>'end_date']) !!}
</div>

@section('scripts')
    <script type="text/javascript">
        $('#end_date').timestamppicker({
            format: 'YYYY-MM-DD HH:mm:ss',
            useCurrent: false
        })
    </script>
@endsection

<!-- Is Active Field -->
<div class="form-group col-sm-6">
    {!! Form::label('is_active', 'Is Active:') !!}
    <label class="checkbox-inline">
        {!! Form::hidden('is_active', 0) !!}
        {!! Form::checkbox('is_active', '1', null) !!}
    </label>
</div>


<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('manageHistories.index') !!}" class="btn btn-default">Cancel</a>
</div>
