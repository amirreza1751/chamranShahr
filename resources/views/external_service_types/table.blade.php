<div class="table-responsive">
    <table class="table" id="externalServiceTypes-table">
        <thead>
            <tr>
                <th>Title</th>
        <th>Version</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($externalServiceTypes as $externalServiceType)
            <tr>
                <td>{!! $externalServiceType->title !!}</td>
            <td>{!! $externalServiceType->version !!}</td>
                <td>
                    {!! Form::open(['route' => ['externalServiceTypes.destroy', $externalServiceType->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{!! route('externalServiceTypes.show', [$externalServiceType->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                        <a href="{!! route('externalServiceTypes.edit', [$externalServiceType->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
