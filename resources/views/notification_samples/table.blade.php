<div class="table-responsive">
    <table class="table" id="notificationSamples-table">
        <thead>
            <tr>
                <th>Title</th>
        <th>Brief Description</th>
        <th>Type</th>
        <th>Notifier Type</th>
        <th>Notifier Id</th>
        <th>Deadline</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($notificationSamples as $notificationSample)
            <tr>
                <td>{{ $notificationSample->title }}</td>
            <td>{{ $notificationSample->brief_description }}</td>
            <td>{{ $notificationSample->type }}</td>
            <td>{{ $notificationSample->notifier_type }}</td>
            <td>{{ $notificationSample->notifier_id }}</td>
            <td>{{ $notificationSample->deadline }}</td>
                <td>
                    {!! Form::open(['route' => ['notificationSamples.destroy', $notificationSample->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('notificationSamples.show', [$notificationSample->id]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                        <a href="{{ route('notificationSamples.edit', [$notificationSample->id]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
