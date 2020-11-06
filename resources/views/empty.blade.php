@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <form action="empty" method="post">
            {{ csrf_field() }}
            <input id="date-field" name="date-field">
            <input type="hidden" id="deadline" name="deadline">
            <button type="submit">submit</button>
        </form>
    </div>
</div>
<script>
    jQuery(document).ready(function () {

        $('#date-field').persianDatepicker({
            observer: true,
            format: 'YYYY/MM/DD',
            altField: '#deadline'
        });

    });
</script>
@endsection
