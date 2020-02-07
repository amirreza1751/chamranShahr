<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Document</title>
{{--    <script>--}}
{{--        window.Laravel = {--}}
{{--            csrfToken: "{{ csrf_token() }}"--}}
{{--        };--}}
{{--    </script>--}}
</head>
<body>
<div id="app">
    @auth <h1>{{Auth()->user()->username}}</h1> @endauth
    <h1>Listening to private notifications... </h1>
</div>

<script src="{{asset('js/app.js')}}" ></script>

@auth
    <script>
         {{--Echo.private('home.{{Auth()->user()->id}}')--}}
         {{--   .listen('NewMessage', (e) => {--}}
         {{--       console.log(e.message);--}}
         {{--   });--}}


         Echo.private('App.User.{{Auth()->user()->id}}')
             .notification((notification) => {
                 console.log(notification);
             });
    </script>
@endauth

</body>
</html>
