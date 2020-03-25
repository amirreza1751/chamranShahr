<div class="table-responsive">
    <table class="table" id="manageHistories-table">
        <thead>
            <tr>
                <th>Manager Id</th>
        <th>Managed Type</th>
        <th>Managed Id</th>
        <th>Begin Date</th>
        <th>End Date</th>
        <th>Is Active</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($manageHistories as $manageHistory)
            <tr>
                <td>{!! $manageHistory->manager_id !!}</td>
            <td>{!! $manageHistory->managed_type !!}</td>
            <td>{!! $manageHistory->managed_id !!}</td>
            <td>{!! $manageHistory->begin_date !!}</td>
            <td>{!! $manageHistory->end_date !!}</td>
            <td>{!! $manageHistory->is_active !!}</td>
                <td>
                    {!! Form::open(['route' => ['manageHistories.destroy', $manageHistory->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{!! route('manageHistories.show', [$manageHistory->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                        <a href="{!! route('manageHistories.edit', [$manageHistory->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
