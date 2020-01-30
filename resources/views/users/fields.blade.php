<!-- First Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('first_name', 'First Name:') !!}
    {!! Form::text('first_name', null, ['class' => 'form-control']) !!}
</div>

<!-- Last Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('last_name', 'Last Name:') !!}
    {!! Form::text('last_name', null, ['class' => 'form-control']) !!}
</div>

<!-- Email Field -->
<div class="form-group col-sm-6">
    {!! Form::label('email', 'Email:') !!}
    {!! Form::email('email', null, ['class' => 'form-control', 'placeholder' => 'like:  your.personal.email@gmail.com']) !!}
</div>

<!-- Username Field -->
<div class="form-group col-sm-6">
    {!! Form::label('username', 'Username:') !!}
    {!! Form::text('username', null, ['class' => 'form-control']) !!}
</div>

<!-- Password Row -->
<div class="col-sm-12" style="padding: 0; margin: 0">
    <!-- Password Field -->
    <div class="form-group col-sm-6">
        {!! Form::label('password', 'Password:') !!}
        <input type="password" class="form-control" name="password" placeholder="Password">
    </div>

    <!-- Confirm Password Field -->
    <div class="form-group col-sm-6">
        {!! Form::label('confirm_password', 'Confirm Password:') !!}
        <input type="password" class="form-control" name="confirm_password" placeholder="Password Again">
    </div>
</div>

<!-- Phone Number Field -->
<div class="form-group col-sm-6">
    {!! Form::label('phone_number', 'Phone Number:') !!}
    {!! Form::text('phone_number', null, ['class' => 'form-control', 'placeholder' => 'like: 0936 123 4567']) !!}
</div>

<!-- Gender Unique Code Field -->
<div class="form-group col-sm-6">
    {!! Form::label('gender_unique_code', 'Gender:') !!}
    <select class="form-control m-bot15" name="gender_unique_code">
        @foreach($genders as $gender)
            @if($gender->unique_code == $user->gender->unique_code)
                <option value="{{ $gender->unique_code }}" selected>{{ $gender->title }}</option>
            @else
                <option value="{{ $gender->unique_code }}">{{ $gender->title }}</option>
            @endif
        @endforeach
    </select>
</div>


<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('users.index') !!}" class="btn btn-default">Cancel</a>
</div>
