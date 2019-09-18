<div class="table-responsive">
    <table class="table" id="media-table">
        <thead>
            <tr>
                <th>Title</th>
        <th>Caption</th>
        <th>Path</th>
        <th>Type</th>
        <th>Owner Type</th>
        <th>Owner Id</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($media as $media)
            <tr>
                <td>{!! $media->title !!}</td>
            <td>{!! $media->caption !!}</td>
            <td>{!! $media->path !!}</td>
            <td>{!! $media->type !!}</td>
            <td>{!! $media->owner_type !!}</td>
            <td>{!! $media->owner_id !!}</td>
                <td>
                    {!! Form::open(['route' => ['media.destroy', $media->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{!! route('media.show', [$media->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                        <a href="{!! route('media.edit', [$media->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
