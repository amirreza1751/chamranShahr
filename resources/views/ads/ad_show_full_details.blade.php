@foreach($ad_array as $key => $value)
    {{$key . "___" . $value}}
@endforeach

{{ $ad->original['title'] }}
{{--//$fields = Illuminate\Support\Facades\Schema::getColumnListing('ads');--}}
{{--//for($i = 0; $i < 17; $i++ ) {--}}
{{--//    echo ($fields[$i] . "<br/>");--}}
{{--//}--}}

