<div class="table-responsive">
    <table class="table" id="studyLevels-table">
        <thead>
            <tr>
                <th>Title</th>
        <th>English Title</th>
        <th>Unique Code</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($studyLevels as $studyLevel)
            <tr>
                <td>{!! $studyLevel->title !!}</td>
            <td>{!! $studyLevel->english_title !!}</td>
            <td>{!! $studyLevel->unique_code !!}</td>
                <td>
                    {!! Form::open(['route' => ['studyLevels.destroy', $studyLevel->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{!! route('studyLevels.show', [$studyLevel->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                        <a href="{!! route('studyLevels.edit', [$studyLevel->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
