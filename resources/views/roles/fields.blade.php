@if(isset($role)) {{--edit view--}}
    <input id="role_id" type="hidden" value="{{$role->id}}">
@endif

<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Name:') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<!-- Guard Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('guard_name', 'Guard Name:') !!}
    <select class="form-control m-bot15" name="guard_name" id="guard_name">
        <option disabled selected value> -- select an option -- </option>
        @if(isset($role)) // edit view
            @foreach($guards as $key => $value)
                @if($value == $role->gender_name)
                    <option value="{{ $value }}" selected>{{ $key }}</option>
                @else
                    <option value="{{ $value }}">{{ $key }}</option>
                @endif
            @endforeach
        @else                   // create view
            @foreach($guards as $key => $value)
                <option value="{{ $value }}">{{ $key }}</option>
            @endforeach
        @endif
    </select>
</div>

<script src="http://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous">
</script>
<script>
    jQuery(document).ready(function(){
        $('select[name="guard_name"]').on('change', function(){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            jQuery.ajax({
                url: "{{ url('/roles/guard_name_ajax') }}",
                method: 'get',
                data: {
                    guard_name: jQuery('#guard_name').val(),
                    id: jQuery('#role_id').val(),
                },
                success: function(data){
                    jQuery('#permission_ids').empty();
                    $.each(data, function(id, permission){
                        if(permission['selected']){
                            $('#permission_ids').append('<option selected value="'+ permission['id'] +'">' + permission['name'] + '</option>');
                        } else {
                            $('#permission_ids').append('<option value="'+ permission['id'] +'">' + permission['name'] + '</option>');
                        }
                    });
                },
                failure: function (data) {
                    console.log('failure');
                    console.log(data);
                }
            });
        });
    });
</script>

<!-- Permission Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('permission_ids', 'Permission Name:') !!}
    <select name="permission_ids[]" id="permission_ids" class="multiselect-ui form-control" multiple="multiple" style="height: 200px; padding: 10px;"></select>
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('roles.index') !!}" class="btn btn-default">Cancel</a>
</div>
