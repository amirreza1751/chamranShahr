<div class="table-responsive">
    <table class="table" id="notifications-table">
        <thead>
            <tr>
                <th>عنوان</th>
        <th>متن</th>
        <th>Type</th>
        <th>Notifiable</th>
        <th>Notifier</th>
        <th>Deadline</th>
        <th>Created At</th>
        <th>Read At</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($notifications as $notification)
            <tr>
                <td>{!! $notification->title !!}</td>
            <td>{!! $notification->brief_description !!}</td>
            <td>{!! $notification->type !!}</td>
            <td>
                @if(isset($notification->notifiable->full_name_scu_id))
                    {!! $notification->notifiable->full_name_scu_id !!}
                @else
{{--                    <script>alert('{{$notification->id}}');</script>--}}
                @endif
            <td>
                @if(isset($notification->notifier->title))
                    {!! $notification->notifier->title !!}
                @endif
            </td>
            <td>{!! $notification->deadline !!}</td>
            <td>{!! $notification->created_at !!}</td>
            <td>{!! $notification->read_at !!}</td>
                <td>
                    {!! Form::open(['route' => ['notifications.destroy', $notification->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{!! route('notifications.show', [$notification->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                        <a href="{!! route('notifications.edit', [$notification->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
