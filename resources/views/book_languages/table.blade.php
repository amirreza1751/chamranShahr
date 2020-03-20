<div class="table-responsive">
    <table class="table" id="bookLanguages-table">
        <thead>
            <tr>
                <th>Title</th>
        <th>English Title</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($bookLanguages as $bookLanguage)
            <tr>
                <td>{{ $bookLanguage->title }}</td>
            <td>{{ $bookLanguage->english_title }}</td>
                <td>
                    {!! Form::open(['route' => ['bookLanguages.destroy', $bookLanguage->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('bookLanguages.show', [$bookLanguage->id]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                        <a href="{{ route('bookLanguages.edit', [$bookLanguage->id]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
