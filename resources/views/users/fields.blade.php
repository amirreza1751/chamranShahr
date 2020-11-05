<!-- First Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('first_name', 'نام:') !!}
    {!! Form::text('first_name', null, ['class' => 'form-control']) !!}
</div>

<!-- Last Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('last_name', 'نام خانوادگی:') !!}
    {!! Form::text('last_name', null, ['class' => 'form-control']) !!}
</div>

<!-- Email Field -->
<div class="form-group col-sm-6">
    {!! Form::label('email', 'پست الکترونیک:') !!}
    {!! Form::email('email', null, ['class' => 'form-control', 'placeholder' => 'like:  your.personal.email@gmail.com']) !!}
</div>

<!-- Username Field -->
<div class="form-group col-sm-6">
    {!! Form::label('username', 'نام کاربری:') !!}
    {!! Form::text('username', null, ['class' => 'form-control']) !!}
</div>

<!-- Password Row -->
<div class="col-sm-12" style="padding: 0; margin: 0">
    <!-- Password Field -->
    <div class="form-group col-sm-6">
        {!! Form::label('password', 'رمز عبور:') !!}
        <input type="password" class="form-control" name="password" placeholder="Password">
    </div>

    <!-- Confirm Password Field -->
    <div class="form-group col-sm-6">
        {!! Form::label('confirm_password', 'تکرار رمز عبور:') !!}
        <input type="password" class="form-control" name="confirm_password" placeholder="Password Again">
    </div>
</div>

<!-- Phone Number Field -->
<div class="form-group col-sm-6">
    {!! Form::label('phone_number', 'شماره تلفن همراه:') !!}
    {!! Form::text('phone_number', null, ['class' => 'form-control', 'placeholder' => 'like: 0936 123 4567']) !!}
</div>

<!-- Gender Unique Code Field -->
<div class="form-group col-sm-6">
    {!! Form::label('gender_unique_code', 'جنسیت:') !!}
    <select class="form-control m-bot15" name="gender_unique_code">
        @if(isset($user))
            @foreach($genders as $gender)
                @if($gender->unique_code == $user->gender->unique_code)
                    <option value="{{ $gender->unique_code }}" selected>{{ $gender->title }}</option>
                @else
                    <option value="{{ $gender->unique_code }}">{{ $gender->title }}</option>
                @endif
            @endforeach
        @else
            @foreach($genders as $gender)
                <option value="{{ $gender->unique_code }}">{{ $gender->title }}</option>
            @endforeach
        @endif
    </select>
</div>

<div class="col-sm-6" style="padding-right: 0">

    <!-- Scu Id Field -->
    <div class="form-group col-sm-12">
        {!! Form::label('scu_id', 'شماره دانشگاهی:') !!}
        {!! Form::text('scu_id', null, ['class' => 'form-control']) !!}
    </div>

    <!-- National Id Field -->
    <div class="form-group col-sm-12">
        {!! Form::label('national_id', 'شماره ملی:') !!}
        {!! Form::text('national_id', null, ['class' => 'form-control']) !!}
    </div>


    <!-- Avatar Path Field -->
    <div class="form-group col-sm-6">
        {!! Form::label('avatar_path', 'تصویر شخصی:') !!}
        <div class="col-md-12">
            <input type="file" name="avatar_path" class="form-control custom-file-input"
                   id="customFile">
            <label style="margin-top: 10px" class="form-control custom-file-label"
                   for="customFile"></label>
        </div>
    </div>
    <div class="form-group col-sm-6">
        {!! Form::label('delete_avatar', 'فعال بودن این گزینه تصویر کاربر را حذف خواهد کرد', ['style' => 'color: lightgray; font-size: 1rem' ]) !!}
        <div class="form-control checkbox" style="margin: 0;">
            <label><input name="delete_avatar" id="delete_avatar" type="checkbox" value="false"><span style="padding-right: 20px;">حذف تصویر</span></label>
        </div>
    </div>
    <script>
        jQuery(document).ready(function(){
            $('#delete_avatar').on('click', function(){
                if($('#delete_avatar').is(":checked")){
                    $('#customFile').prop('disabled', true);
                    $('#delete_avatar').val(true);
                } else {
                    $('#customFile').prop('disabled', false);
                    $('#delete_avatar').val(false);
                }
            });
        });
    </script>
</div>

<!-- Role IDs Field -->
<div class="form-group col-sm-6">
    {!! Form::label('role_ids', 'نقش‌ها:') !!}
    <select name="role_ids[]" id="role_ids" class="multiselect-ui form-control" multiple="multiple" style="height: 200px; padding: 10px;">
        @if(isset($roles))
            @foreach($roles as $role)
                @if($role->selected)
                    <option value="{{ $role->id }}" selected>{{ $role->name }}</option>
                @else
                    <option value="{{ $role->id  }}">{{ $role->name }}</option>
                @endif
            @endforeach
        @endif
    </select>
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('ذخیره', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('users.index') !!}" class="btn btn-default">لغو</a>
</div>
