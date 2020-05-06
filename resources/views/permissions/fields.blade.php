@if(isset($permission)) {{--edit view--}}
    <input id="permission_id" type="hidden" value="{{$permission->id}}">
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
        @if(isset($permission)) // edit view
            @foreach($guards as $key => $value)
                @if($value == $permission->gender_name)
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

<script>
    jQuery(document).ready(function(){
        $('select[name="guard_name"]').on('change', function(){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            jQuery.ajax({
                url: "{{ url('/permissions/guard_name_ajax') }}",
                method: 'get',
                data: {
                    guard_name: jQuery('#guard_name').val(),
                    id: jQuery('#permission_id').val(),
                },
                success: function(data){
                    jQuery('#role_ids').empty();
                    $.each(data, function(id, role){
                        if(role['selected']){
                            $('#role_ids').append('<option selected value="'+ role['id'] +'">' + role['name'] + '</option>');
                        } else {
                            $('#role_ids').append('<option value="'+ role['id'] +'">' + role['name'] + '</option>');
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


<!-- Role Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('role_ids', 'Role Name:') !!}
    <select name="role_ids[]" id="role_ids" class="multiselect-ui form-control" multiple="multiple"></select>
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('permissions.index') !!}" class="btn btn-default">Cancel</a>
</div>
