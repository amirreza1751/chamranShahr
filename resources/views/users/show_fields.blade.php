<div class="row">
    <div class="col-sm-6">
        <!-- Avatar Path Field -->
        <div class="form-group">
            <div class="card" style="max-width: 80%">
                <img class="card-img-top" src="{{ $user->avatar }}" alt="Card image">
                <div class="card-body">
                    <h4 class="card-title">{!! Form::label('avatar_path', 'تصویر شخصی') !!}</h4>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6">
        <!-- First Name Field -->
        <div class="form-group">
            {!! Form::label('first_name', 'نام:') !!}
            <P>{!! $user->first_name !!}</P>
        </div>

        <!-- Last Name Field -->
        <div class="form-group">
            {!! Form::label('last_name', 'نام‌خانوادگی:') !!}
            <P>{!! $user->last_name !!}</P>
        </div>

        <!-- Email Field -->
        <div class="form-group">
            {!! Form::label('email', 'پست الکترونیک:') !!}
            <P>{!! $user->email !!}</P>
        </div>

        <!-- Birthday Field -->
        <div class="form-group">
            {!! Form::label('birthday', 'تاریخ تولد:') !!}
            <P>{!! $user->birthday !!}</P>
        </div>

        <!-- Username Field -->
        <div class="form-group">
            {!! Form::label('username', 'نام کاربری:') !!}
            <P>{!! $user->username !!}</P>
        </div>

        <!-- Scu Id Field -->
        <div class="form-group">
            {!! Form::label('scu_id', 'شماره‌ی دانشگاهی:') !!}
            <P>{!! $user->scu_id !!}</P>
        </div>

        <!-- National Id Field -->
        <div class="form-group">
            {!! Form::label('national_id', 'شماره‌ی ملی:') !!}
            <P>{!! $user->national_id !!}</P>
        </div>

        <!-- Phone Number Field -->
        <div class="form-group">
            {!! Form::label('phone_number', 'شماره تماس:') !!}
            <p>{!! $user->phone_number !!}</p>
        </div>

        <!-- Last Login Field -->
        <div class="form-group">
            {!! Form::label('last_login', 'آخرین ورود:') !!}
            <p>{!! $user->last_login !!}</p>
        </div>

        <!-- Created At Field -->
        <div class="form-group">
            {!! Form::label('created_at', 'ساخته شده در:') !!}
            <p>{!! $user->created_at !!}</p>
        </div>

        <!-- Updated At Field -->
        <div class="form-group">
            {!! Form::label('updated_at', 'آخرین ویرایش:') !!}
            <p>{!! $user->updated_at !!}</p>
        </div>

        <!-- Deleted At Field -->
        <div class="form-group">
            {!! Form::label('deleted_at', 'حذف شده در:') !!}
            <p>{!! $user->deleted_at !!}</p>
        </div>
    </div>

</div>
