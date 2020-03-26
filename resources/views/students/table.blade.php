<div class="table-responsive">
    <table class="table" id="students-table">
        <thead>
            <tr>
                <th>User Id</th>
        <th>Study Area Unique Code</th>
        <th>Study Level Unique Code</th>
        <th>Entrance Term Unique Code</th>
        <th>Study Status Unique Code</th>
        <th>Total Average</th>
        <th>Is Active</th>
        <th>Is Guest</th>
        <th>Is Iranian</th>
        <th>In Dormitory</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($students as $student)
            <tr>
                <td>{!! $student->user_id !!}</td>
            <td>{!! $student->study_area_unique_code !!}</td>
            <td>{!! $student->study_level_unique_code !!}</td>
            <td>{!! $student->entrance_term_unique_code !!}</td>
            <td>{!! $student->study_status_unique_code !!}</td>
            <td>{!! $student->total_average !!}</td>
            <td>{!! $student->is_active !!}</td>
            <td>{!! $student->is_guest !!}</td>
            <td>{!! $student->is_iranian !!}</td>
            <td>{!! $student->in_dormitory !!}</td>
                <td>
                    {!! Form::open(['route' => ['students.destroy', $student->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{!! route('students.show', [$student->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                        <a href="{!! route('students.edit', [$student->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
