<div class="table-responsive">
    <table class="table" id="locations-table">
        <thead>
            <tr>
                <th>X</th>
        <th>Y</th>
        <th>Title</th>
        <th>Brief Description</th>
        <th>Owner Type</th>
        <th>Owner Id</th>
        <th>Type</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($locations as $location)
            <tr>
                <td>{!! $location->x !!}</td>
            <td>{!! $location->y !!}</td>
            <td>{!! $location->title !!}</td>
            <td>{!! $location->brief_description !!}</td>
            <td>{!! $location->owner_type !!}</td>
            <td>{!! $location->owner_id !!}</td>
            <td>{!! $location->type !!}</td>
                <td>
                    {!! Form::open(['route' => ['locations.destroy', $location->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{!! route('locations.show', [$location->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                        <a href="{!! route('locations.edit', [$location->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
