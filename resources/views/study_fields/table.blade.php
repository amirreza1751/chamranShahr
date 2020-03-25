<div class="table-responsive">
    <table class="table" id="studyFields-table">
        <thead>
            <tr>
                <th>Unique Code</th>
        <th>Faculty Unique Code</th>
        <th>Department Id</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($studyFields as $studyField)
            <tr>
                <td>{!! $studyField->unique_code !!}</td>
            <td>{!! $studyField->faculty_unique_code !!}</td>
            <td>{!! $studyField->department_id !!}</td>
                <td>
                    {!! Form::open(['route' => ['studyFields.destroy', $studyField->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{!! route('studyFields.show', [$studyField->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                        <a href="{!! route('studyFields.edit', [$studyField->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
