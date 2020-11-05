<div class="table-responsive">
    <table class="table" id="users-table">
        <thead>
        <tr>
            <th>نام و نام‌خانوادگی</th>
            <th>پست الکترونیک</th>
            <th>نام کاربری</th>
            <th>شماره دانشگاهی</th>
            <th>شماره‌ی ملی</th>
            <th>شماره‌ی تلفن‌همراه</th>
            <th>جنسیت</th>
            <th>سطح</th>
            <th colspan="3" style="width: 12rem">اقدام</th>
        </tr>
        </thead>
        <tbody>
        @foreach($users as $user)
            <tr>
                <td style="width:15rem">{!! $user->first_name.' '.$user->last_name !!}</td>
                <td>{!! $user->email !!}</td>
                <td>{!! $user->username !!}</td>
                <td>{!! $user->scu_id !!}</td>
                <td>{!! $user->national_id !!}</td>
                <td>{!! $user->phone_number !!}</td>
                <td>{!! $user->gender->title !!}</td>
                <td>
                    @foreach($user->roles as $role)
                        <span class="label label-success">{{ $role->name }}</span>
                    @endforeach
                </td>
                <td>
                    {!! Form::open(['route' => ['users.destroy', $user->id], 'method' => 'delete']) !!}
                    <div class='btn-group td-action'>
                        <a href="{!! route('users.show', [$user->id]) !!}" class='btn btn-default btn-xs'><i
                                class="glyphicon glyphicon-eye-open"></i></a>
                        <a href="{!! route('users.edit', [$user->id]) !!}" class='btn btn-default btn-xs'><i
                                class="glyphicon glyphicon-edit"></i></a>
{{--                        <a data-toggle="tooltip" title="حذف محرومیت 12 ساعته از ورود به علت تکرار بیش از حد پسورد اشتباه " href="{!! route('users.unrestricted', [$user->id]) !!}" class='btn btn-info btn-xs'><i--}}
{{--                                class="fa fa-unlock-alt"></i></a>--}}
{{--                        <a data-toggle="tooltip" title="محدود کردن  دسترسی کاربر به سامانه برای مدت 12 ساعت" href="{!! route('users.restrict', [$user->id]) !!}" class='btn btn-warning btn-xs'><i--}}
{{--                                class="fa fa-lock"></i></a>--}}
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
