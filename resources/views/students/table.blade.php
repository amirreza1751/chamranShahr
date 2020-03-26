<div class="table-responsive">
    <table class="table" id="students-table">
        <thead>
            <tr>
                <th>User Name</th>
        <th>Study Area</th>
        <th>Study Level</th>
        <th>Entrance Term</th>
        <th>Study Status</th>
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
                <td>{!! $student->user->first_name . ' ' . $student->user->last_name !!}</td>
            <td>{!! $student->study_area->title !!}</td>
            <td>{!! $student->study_level->title !!}</td>
            <td>{!! $student->entrance_term->title !!}</td>
            <td>{!! $student->study_status->title !!}</td>
            <td>{!! $student->total_average !!}</td>
            <td>@if(isset($student->is_active)) @if($student->is_active) بله @else خیر @endif @endif</td>
            <td>@if(isset($student->is_guest)) @if($student->is_guest) بله @else خیر @endif @endif</td>
            <td>@if(isset($student->is_iranian)) @if($student->is_iranian) بله @else خیر @endif @endif</td>
            <td>@if(isset($student->in_dormitory)) @if($student->in_dormitory) بله @else خیر @endif @endif</td>
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
