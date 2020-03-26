<div class="table-responsive">
    <table class="table" id="manageHierarchies-table">
        <thead>
            <tr>
                <th>Manage Type</th>
        <th>Manage Id</th>
        <th>Managed By Type</th>
        <th>Managed By Id</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($manageHierarchies as $manageHierarchy)
            <tr>
                <td>{!! $manageHierarchy->manage_type !!}</td>
            <td>{!! $manageHierarchy->manage_id !!}</td>
            <td>{!! $manageHierarchy->managed_by_type !!}</td>
            <td>{!! $manageHierarchy->managed_by_id !!}</td>
                <td>
                    {!! Form::open(['route' => ['manageHierarchies.destroy', $manageHierarchy->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{!! route('manageHierarchies.show', [$manageHierarchy->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                        <a href="{!! route('manageHierarchies.edit', [$manageHierarchy->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
