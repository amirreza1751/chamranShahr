<div class="table-responsive">
    <table class="table" id="notices-table">
        <thead>
            <tr>
                <th>Title</th>
        <th>Link</th>
        <th>Path</th>
        <th>Description</th>
        <th>Author</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($notices as $notice)
            <tr>
                <td>{!! $notice->title !!}</td>
            <td>{!! $notice->link !!}</td>
            <td>{!! $notice->path !!}</td>
            <td>{!! $notice->description !!}</td>
            <td>{!! $notice->author !!}</td>
                <td>
                    {!! Form::open(['route' => ['notices.destroy', $notice->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{!! route('notices.show', [$notice->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                        <a href="{!! route('notices.edit', [$notice->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
