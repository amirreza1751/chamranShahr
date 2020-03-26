<div class="table-responsive">
    <table class="table" id="studyAreas-table">
        <thead>
            <tr>
                <th>Title</th>
        <th>English Title</th>
        <th>Unique Code</th>
        <th>Is Active</th>
        <th>Study Level Unique Code</th>
        <th>Study Field Unique Code</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($studyAreas as $studyArea)
            <tr>
                <td>{!! $studyArea->title !!}</td>
            <td>{!! $studyArea->english_title !!}</td>
            <td>{!! $studyArea->unique_code !!}</td>
            <td>{!! $studyArea->is_active !!}</td>
            <td>{!! $studyArea->study_level_unique_code !!}</td>
            <td>{!! $studyArea->study_field_unique_code !!}</td>
                <td>
                    {!! Form::open(['route' => ['studyAreas.destroy', $studyArea->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{!! route('studyAreas.show', [$studyArea->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                        <a href="{!! route('studyAreas.edit', [$studyArea->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
