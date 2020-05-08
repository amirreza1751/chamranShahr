<div class="table-responsive">
    <table class="table" id="users-table">
        <thead>
        <tr>
            <th>نام و نام‌خانوادگی</th>
            <th>پست الکترونیک</th>
            <th>تاریخ تولد</th>
            <th>نام کاربری</th>
            <th>شماره دانشگاهی</th>
            <th>شماره‌ی ملی</th>
            <th>شماره‌ی تلفن‌همراه</th>
            <th>جنسیت</th>
            <th>تایید شده</th>
            <th colspan="3">مدیریت</th>
        </tr>
        </thead>
        <tbody>
        @foreach($users as $user)
            <tr>
                <td>{!! $user->first_name.' '.$user->last_name !!}</td>
                <td>{!! $user->email !!}</td>
                <td>{!! $user->birthday !!}</td>
                <td>{!! $user->username !!}</td>
                <td>{!! $user->scu_id !!}</td>
                <td>{!! $user->national_id !!}</td>
                <td>{!! $user->phone_number !!}</td>
                <td>{!! $user->gender->title !!}</td>
                <td>@if($user->is_verified) بله @else خیر @endif</td>
                <td>
                    {!! Form::open(['route' => ['users.destroy', $user->id], 'method' => 'delete']) !!}
                    <div class='btn-group td-action'>
                        <a href="{!! route('users.show', [$user->id]) !!}" class='btn btn-default btn-xs'><i
                                class="glyphicon glyphicon-eye-open"></i></a>
                        <a href="{!! route('users.edit', [$user->id]) !!}" class='btn btn-default btn-xs'><i
                                class="glyphicon glyphicon-edit"></i></a>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
