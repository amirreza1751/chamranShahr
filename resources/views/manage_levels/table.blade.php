<div class="table-responsive">
    <table class="table" id="manageLevels-table">
        <thead>
            <tr>
                <th>Management Title</th>
        <th>English Management Title</th>
        <th>Manager Title</th>
        <th>English Manager Title</th>
        <th>Level</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($manageLevels as $manageLevel)
            <tr>
                <td>{!! $manageLevel->management_title !!}</td>
            <td>{!! $manageLevel->english_management_title !!}</td>
            <td>{!! $manageLevel->manager_title !!}</td>
            <td>{!! $manageLevel->english_manager_title !!}</td>
            <td>{!! $manageLevel->level !!}</td>
                <td>
                    {!! Form::open(['route' => ['manageLevels.destroy', $manageLevel->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{!! route('manageLevels.show', [$manageLevel->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                        <a href="{!! route('manageLevels.edit', [$manageLevel->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
