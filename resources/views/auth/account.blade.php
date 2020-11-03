<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>چمران‌شهر - ورود</title>

    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Ionicons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">

    <!-- Theme style -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/2.4.3/css/AdminLTE.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/2.4.3/css/skins/_all-skins.min.css">

    <!-- iCheck -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/iCheck/1.0.2/skins/square/_all.css">

    <!-- Custom Css -->
    <link rel="stylesheet" href="{{ asset('/css/custom.css') }}">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>
<body class="hold-transition login-page vazir-font-fd">
<div class="login-box">

    @include('flash::message')
    @include('adminlte-templates::common.errors')

    <div class="login-logo">
        <a href="{{ url('/home') }}"><b>چمران‌شهر </b></a>
    </div>

    <!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg">لطفا وارد سامانه شوید</p>

        <form method="post" action="{{ route('auth.password') }}">
            {!! csrf_field() !!}
            <div id="phone_number_group" class="form-group">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-mobile-phone"></i></span>
                    <input name="phone_number" dir="ltr" type="text" style="text-align:center;" pattern="\d*" maxlength="11" class="form-control" placeholder="شماره تلفن همراه">
                    <span class="input-group-btn">
                      <button id="send_otp_button" onclick="send_otp()" type="button" class="btn btn-info btn-flat">ارسال کد</button>
                    </span>
                </div>
                <div class="form-group">
                    <div class="col-xs-10" style="padding-right: 0"><span id="phone_number_error" class="help-block" style="display: none"></span></div>
                    <div class="col-xs-2" style="padding-left: 3rem; padding-top: 0.5rem"><span id="timer" class="pull-left"></span></div>
                </div>
            </div>
            <div class="form-group">
                <input id="otp_code" name="otp_code" dir="ltr" type="text" style="text-align:center; letter-spacing: 1.5rem;" pattern="\d*" maxlength="5" class="form-control otp" placeholder="کد 5 رقمی">
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <button type="submit" class="btn btn-primary btn-block btn-flat">مرحله‌ی بعد</button>
                </div>
                <!-- /.col -->
            </div>
        </form>


    </div>
    <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<!-- AdminLTE App -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/2.4.3/js/adminlte.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/iCheck/1.0.2/icheck.min.js"></script>
<script>
    $(function () {
        $('input').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%' // optional
        });
    });
</script>

<script type="text/javascript">

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    function send_otp() {
        var phone_number = $("input[name=phone_number]").val();

        $.ajax({
            type:'POST',
            url:"{{ route('custom_login.send_otp_ajax') }}",
            data:{_token: '{{ csrf_token() }}',phone_number:phone_number},
            success:function(data){
                var phone_number_error = $("#phone_number_error");
                var phone_number_group = $("#phone_number_group");

                if (data.success){

                    /** disable send otp button for 120 seconds */
                    document.getElementById("send_otp_button").disabled = true;
                    setTimeout(function() {
                        document.getElementById("send_otp_button").disabled = false;
                    }, 120000);

                    /** 120 seconds countdown */
                    var seconds_left = 120;
                    var interval = setInterval(function() {
                        document.getElementById('timer').innerHTML = --seconds_left;

                        if (seconds_left <= 0)
                        {
                            document.getElementById('timer').innerHTML = "";
                            clearInterval(interval);
                        }
                    }, 1000);

                    phone_number_group.removeClass('has-error');
                    phone_number_group.addClass('has-success');
                    phone_number_error.text(data.message);
                    phone_number_error.show();
                }
                else{
                    phone_number_group.removeClass('has-success');
                    phone_number_group.addClass('has-error');
                    phone_number_error.text(data.message);
                    phone_number_error.show();
                }
            }
        });
    }
</script>

<script>
    // $(document).ready(function(){
    //     var otp_code = $("#otp_code");
    //     otp_code.keyup(function(){
    //         value = otp_code.val();
    //         value = value.split('-').join('');
    //         value = value.match(/.{1}/g).join('-');
    //         // alert(value);
    //         otp_code.val(value);
    //     });
    // });
    $(document).ready(function(){
        $(':input[type="submit"]').prop('disabled', true);
        var otp_code = $("#otp_code");
        otp_code.keyup(function() {
            var otp = otp_code.val();

            var otp_regex = new RegExp('^[0-9]{5}$');

            if(otp_regex.test(otp)) {
                $(':input[type="submit"]').prop('disabled', false);
            } else {
                $(':input[type="submit"]').prop('disabled', true);
            }
        });
    });
</script>
</body>
</html>
