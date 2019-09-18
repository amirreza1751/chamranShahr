<div class="table-responsive">
    <table class="table" id="notifications-table">
        <thead>
            <tr>
                <th>Title</th>
        <th>Brief Description</th>
        <th>Type</th>
        <th>Notifiable Type</th>
        <th>Notifiable Id</th>
        <th>Notifier Type</th>
        <th>Notifier Id</th>
        <th>Deadline</th>
        <th>Data</th>
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
            <td>{!! $notification->notifiable_type !!}</td>
            <td>{!! $notification->notifiable_id !!}</td>
            <td>{!! $notification->notifier_type !!}</td>
            <td>{!! $notification->notifier_id !!}</td>
            <td>{!! $notification->deadline !!}</td>
            <td>{!! $notification->data !!}</td>
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
