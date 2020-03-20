<div class="table-responsive">
    <table class="table" id="bookSizes-table">
        <thead>
            <tr>
                <th>Size Name</th>
        <th>English Size Name</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($bookSizes as $bookSize)
            <tr>
                <td>{{ $bookSize->size_name }}</td>
            <td>{{ $bookSize->english_size_name }}</td>
                <td>
                    {!! Form::open(['route' => ['bookSizes.destroy', $bookSize->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('bookSizes.show', [$bookSize->id]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                        <a href="{{ route('bookSizes.edit', [$bookSize->id]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
