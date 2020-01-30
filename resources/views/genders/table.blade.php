<div class="table-responsive">
    <table class="table" id="genders-table">
        <thead>
            <tr>
                <th>Title</th>
        <th>English Title</th>
        <th>Unique Code</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($genders as $gender)
            <tr>
                <td>{!! $gender->title !!}</td>
            <td>{!! $gender->english_title !!}</td>
            <td>{!! $gender->unique_code !!}</td>
                <td>
                    {!! Form::open(['route' => ['genders.destroy', $gender->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{!! route('genders.show', [$gender->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                        <a href="{!! route('genders.edit', [$gender->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
