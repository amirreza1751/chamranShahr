<div class="table-responsive">
    <table class="table" id="studyStatuses-table">
        <thead>
            <tr>
                <th>Title</th>
        <th>English Title</th>
        <th>Unique Code</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($studyStatuses as $studyStatus)
            <tr>
                <td>{!! $studyStatus->title !!}</td>
            <td>{!! $studyStatus->english_title !!}</td>
            <td>{!! $studyStatus->unique_code !!}</td>
                <td>
                    {!! Form::open(['route' => ['studyStatuses.destroy', $studyStatus->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{!! route('studyStatuses.show', [$studyStatus->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                        <a href="{!! route('studyStatuses.edit', [$studyStatus->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
