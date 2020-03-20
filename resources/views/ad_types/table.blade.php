<div class="table-responsive">
    <table class="table" id="adTypes-table">
        <thead>
            <tr>
                <th>Ad Type Title</th>
        <th>English Ad Type Title</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($adTypes as $adType)
            <tr>
                <td>{{ $adType->ad_type_title }}</td>
            <td>{{ $adType->english_ad_type_title }}</td>
                <td>
                    {!! Form::open(['route' => ['adTypes.destroy', $adType->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('adTypes.show', [$adType->id]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                        <a href="{{ route('adTypes.edit', [$adType->id]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
