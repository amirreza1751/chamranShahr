<div class="table-responsive">
    <table class="table" id="departments-table">
        <thead>
            <tr>
                <th>Title</th>
        <th>English Title</th>
        <th>Description</th>
        <th>Path</th>
        <th>Manage Level Id</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($departments as $department)
            <tr>
                <td>{!! $department->title !!}</td>
            <td>{!! $department->english_title !!}</td>
            <td>{!! $department->description !!}</td>
            <td>{!! $department->path !!}</td>
            <td>{!! $department->manage_level_id !!}</td>
                <td>
                    {!! Form::open(['route' => ['departments.destroy', $department->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{!! route('departments.show', [$department->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                        <a href="{!! route('departments.edit', [$department->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
