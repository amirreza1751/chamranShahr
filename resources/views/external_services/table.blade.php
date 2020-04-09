<div class="table-responsive">
    <table class="table" id="externalServices-table">
        <thead>
            <tr>
                <th>Title</th>
        <th>English Title</th>
        <th class="col-sm-4">Url</th>
        <th>Type Id</th>
        <th>Content Type</th>
        <th>Owner</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($externalServices as $externalService)
            <tr>
                <td>{!! $externalService->title !!}</td>
            <td>{!! $externalService->english_title !!}</td>
            <td><a href="{!! $externalService->url !!}">{!! $externalService->url !!}</a></td>
            <td>{!! $externalService->type->title !!}  <a href="{!! route('externalServiceTypes.show', [$externalService->type->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a></td>
            <td>{!!  array_last(explode("\\", $externalService->content_type)) !!}<a href="{!! route(app($externalService->content_type)->getTable() . '.index') !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a></td>
            <td>{!! $externalService->owner->title !!} <a href="{!! route(app( $externalService->owner_type)->getTable() . '.show', [$externalService->owner->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a></td>
                <td>
                    {!! Form::open(['route' => ['externalServices.destroy', $externalService->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{!! route('externalServices.show', [$externalService->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                        <a href="{!! route('externalServices.edit', [$externalService->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
