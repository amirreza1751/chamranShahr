<div class="table-responsive">
    <table class="table" id="ads-table">
        <thead>
            <tr>
                <th>Title</th>
        <th>English Title</th>
        <th>Ad Location</th>
        <th>English Ad Location</th>
        <th>Advertisable Type</th>
        <th>Advertisable Id</th>
        <th>Offered Price</th>
        <th>Phone Number</th>
        <th>Description</th>
        <th>Is Verified</th>
        <th>Is Special</th>
        <th>Category Id</th>
        <th>Ad Type Id</th>
        <th>Creator Id</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($ads as $ad)
            <tr class="  @if($ad->is_verified == 1) {{' bg-success '}}@endif">
                <td><a href="{{route('show_advertisable', $ad->id)}}">{{ $ad->title }}</a></td>
            <td>{{ $ad->english_title }}</td>
            <td>{{ $ad->ad_location }}</td>
            <td>{{ $ad->english_ad_location }}</td>
            <td>{{ $ad->advertisable_type }}</td>
            <td>{{ $ad->advertisable_id }}</td>
            <td>{{ $ad->offered_price }}</td>
            <td>{{ $ad->phone_number }}</td>
            <td>{{ $ad->description }}</td>
            <td>{{ $ad->is_verified }}</td>
            <td>{{ $ad->is_special }}</td>
            <td>{{ $ad->category_id }}</td>
            <td>{{ $ad->ad_type_id }}</td>
            <td>{{ $ad->creator_id }}</td>
                <td>
                    {!! Form::open(['route' => ['ads.destroy', $ad->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('ads.show', [$ad->id]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                        <a href="{{ route('ads.edit', [$ad->id]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                        <a href="{{ route('verify_ad', [$ad->id]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-ok"></i></a>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
