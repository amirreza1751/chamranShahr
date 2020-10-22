@extends('layouts.app')

@section('content')
    @include('adminlte-templates::common.errors')
    @include('flash::message')
    <section class="content-header">
        <h1>
            صفحه‌ی شخصی
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('home') }}"><i class="fa fa-dashboard"></i>داشبورد</a></li>
            <li class="active">صفحه‌ی شخصی</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-lg-4">

                <!-- Profile Image -->
                <div class="box box-primary">
                    <div class="box-body box-profile">
                        <img class="profile-user-img img-responsive img-circle image-square-15" src="{{ Auth::user()->avatar() }}"
                             alt="User profile picture">

                        <h3 class="profile-username text-center">{{ Auth::user()->full_name }}</h3>

                        <p class="text-muted text-center">مدیر</p>

                        <ul class="list-group list-group-unbordered">
                            @foreach(Auth::user()->managements() as $management)
                                <li class="list-group-item">
                                    <b>مدیریت</b> <a class="pull-left">{{ $management->managed->title }}</a>
                                </li>
                            @endforeach
                            <li class="list-group-item">
                                <b>آخرین ورود</b> <a
                                    class="pull-left">{{ Morilog\Jalali\Jalalian::fromDateTime(Auth::user()->last_login)->format('%A, %d %B') }}
                                    ساعت {{ Morilog\Jalali\Jalalian::fromDateTime(Auth::user()->last_login)->format('h:m A') }}</a>
                            </li>
                            <li class="list-group-item">
                                <b>پست الکترونیک</b> <a class="pull-left">{{ Auth::user()->email }}</a>
                            </li>
                            <li class="list-group-item">
                                <b>نام کاربری</b> <a class="pull-left">{{ Auth::user()->username }}</a>
                            </li>
                        </ul>

                        <a disabled="disabled" class="btn btn-primary btn-block"><b>مشاهده‌ی صفحه‌ی عمومی</b></a>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->

                <!-- About Me Box -->
                <div class="box box-default">
                    <div class="box-header with-border">
                        <h3 class="box-title">درباره‌ی من</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        {{--                        <strong><i class="fa fa-book margin-r-5"></i> Education</strong>--}}

                        <p class="text-muted">
                            مدیر فناوری و اطلاعات دانشگاه شهید چمران اهواز، هیئت علمی گروه مهندسی کامپیوتر
                        </p>

                        {{--                        <hr>--}}

                        {{--                        <strong><i class="fa fa-map-marker margin-r-5"></i> Location</strong>--}}

                        {{--                        <p class="text-muted">Malibu, California</p>--}}

                        {{--                        <hr>--}}

                        {{--                        <strong><i class="fa fa-pencil margin-r-5"></i> Skills</strong>--}}

                        {{--                        <p>--}}
                        {{--                            <span class="label label-danger">UI Design</span>--}}
                        {{--                            <span class="label label-success">Coding</span>--}}
                        {{--                            <span class="label label-info">Javascript</span>--}}
                        {{--                            <span class="label label-warning">PHP</span>--}}
                        {{--                            <span class="label label-primary">Node.js</span>--}}
                        {{--                        </p>--}}

                        {{--                        <hr>--}}

                        {{--                        <strong><i class="fa fa-file-text-o margin-r-5"></i> Notes</strong>--}}

                        {{--                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam fermentum enim neque.</p>--}}
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
            <div class="col-md-8">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs pull-right">
                        <li class="active"><a href="#notifications" data-toggle="tab" aria-expanded="false">نوتیفیکیشن‌ها</a>
                        </li>
                        {{--                        <li class=""><a href="#timeline" data-toggle="tab" aria-expanded="false">Timeline</a></li>--}}
                        <li class=""><a href="#settings" data-toggle="tab" aria-expanded="true">تنظیمات حساب</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="notifications">
                            @foreach($notifications as $notification)
                                <div class="attachment-block clearfix">
                                    <img class="attachment-img attachment-img-custom" src="{{ $notification->notifier->thumbnail }}"
                                         alt="Attachment Image">

                                    <div class="attachment-pushed">
                                        <h4 class="attachment-heading"><a>{{ $notification->title }}</a></h4>

                                        <div class="attachment-text">
                                            {{ $notification->brief_description }}
                                            <a href="{!! route('notifications.show', [$notification->id]) !!}">more</a>
                                        </div>
                                        <!-- /.attachment-text -->
                                    </div>
                                    <!-- /.attachment-pushed -->
                                </div>
                            @endforeach

                            {{--                            <!-- Post -->--}}
                            {{--                            <div class="post">--}}
                            {{--                                <div class="user-block">--}}
                            {{--                                    <img class="img-circle img-bordered-sm" src="../../dist/img/user1-128x128.jpg"--}}
                            {{--                                         alt="user image">--}}
                            {{--                                    <span class="username">--}}
                            {{--                                      <a href="#">Jonathan Burke Jr.</a>--}}
                            {{--                                      <a href="#" class="pull-right btn-box-tool"><i class="fa fa-times"></i></a>--}}
                            {{--                                    </span>--}}
                            {{--                                    <span class="description">Shared publicly - 7:30 PM today</span>--}}
                            {{--                                </div>--}}
                            {{--                                <!-- /.user-block -->--}}
                            {{--                                <p>--}}
                            {{--                                    Lorem ipsum represents a long-held tradition for designers,--}}
                            {{--                                    typographers and the like. Some people hate it and argue for--}}
                            {{--                                    its demise, but others ignore the hate as they create awesome--}}
                            {{--                                    tools to help create filler text for everyone from bacon lovers--}}
                            {{--                                    to Charlie Sheen fans.--}}
                            {{--                                </p>--}}
                            {{--                                <ul class="list-inline">--}}
                            {{--                                    <li><a href="#" class="link-black text-sm"><i class="fa fa-share margin-r-5"></i>--}}
                            {{--                                            Share</a></li>--}}
                            {{--                                    <li><a href="#" class="link-black text-sm"><i--}}
                            {{--                                                class="fa fa-thumbs-o-up margin-r-5"></i> Like</a>--}}
                            {{--                                    </li>--}}
                            {{--                                    <li class="pull-right">--}}
                            {{--                                        <a href="#" class="link-black text-sm"><i--}}
                            {{--                                                class="fa fa-comments-o margin-r-5"></i> Comments--}}
                            {{--                                            (5)</a></li>--}}
                            {{--                                </ul>--}}

                            {{--                                <input class="form-control input-sm" type="text" placeholder="Type a comment">--}}
                            {{--                            </div>--}}
                            {{--                            <!-- /.post -->--}}

                            {{--                            <!-- Post -->--}}
                            {{--                            <div class="post clearfix">--}}
                            {{--                                <div class="user-block">--}}
                            {{--                                    <img class="img-circle img-bordered-sm" src="../../dist/img/user7-128x128.jpg"--}}
                            {{--                                         alt="User Image">--}}
                            {{--                                    <span class="username">--}}
                            {{--                          <a href="#">Sarah Ross</a>--}}
                            {{--                          <a href="#" class="pull-right btn-box-tool"><i class="fa fa-times"></i></a>--}}
                            {{--                        </span>--}}
                            {{--                                    <span class="description">Sent you a message - 3 days ago</span>--}}
                            {{--                                </div>--}}
                            {{--                                <!-- /.user-block -->--}}
                            {{--                                <p>--}}
                            {{--                                    Lorem ipsum represents a long-held tradition for designers,--}}
                            {{--                                    typographers and the like. Some people hate it and argue for--}}
                            {{--                                    its demise, but others ignore the hate as they create awesome--}}
                            {{--                                    tools to help create filler text for everyone from bacon lovers--}}
                            {{--                                    to Charlie Sheen fans.--}}
                            {{--                                </p>--}}

                            {{--                                <form class="form-horizontal">--}}
                            {{--                                    <div class="form-group margin-bottom-none">--}}
                            {{--                                        <div class="col-sm-9">--}}
                            {{--                                            <input class="form-control input-sm" placeholder="Response">--}}
                            {{--                                        </div>--}}
                            {{--                                        <div class="col-sm-3">--}}
                            {{--                                            <button type="submit" class="btn btn-danger pull-right btn-block btn-sm">--}}
                            {{--                                                Send--}}
                            {{--                                            </button>--}}
                            {{--                                        </div>--}}
                            {{--                                    </div>--}}
                            {{--                                </form>--}}
                            {{--                            </div>--}}
                            {{--                            <!-- /.post -->--}}

                            {{--                            <!-- Post -->--}}
                            {{--                            <div class="post">--}}
                            {{--                                <div class="user-block">--}}
                            {{--                                    <img class="img-circle img-bordered-sm" src="../../dist/img/user6-128x128.jpg"--}}
                            {{--                                         alt="User Image">--}}
                            {{--                                    <span class="username">--}}
                            {{--                          <a href="#">Adam Jones</a>--}}
                            {{--                          <a href="#" class="pull-right btn-box-tool"><i class="fa fa-times"></i></a>--}}
                            {{--                        </span>--}}
                            {{--                                    <span class="description">Posted 5 photos - 5 days ago</span>--}}
                            {{--                                </div>--}}
                            {{--                                <!-- /.user-block -->--}}
                            {{--                                <div class="row margin-bottom">--}}
                            {{--                                    <div class="col-sm-6">--}}
                            {{--                                        <img class="img-responsive" src="../../dist/img/photo1.png" alt="Photo">--}}
                            {{--                                    </div>--}}
                            {{--                                    <!-- /.col -->--}}
                            {{--                                    <div class="col-sm-6">--}}
                            {{--                                        <div class="row">--}}
                            {{--                                            <div class="col-sm-6">--}}
                            {{--                                                <img class="img-responsive" src="../../dist/img/photo2.png" alt="Photo">--}}
                            {{--                                                <br>--}}
                            {{--                                                <img class="img-responsive" src="../../dist/img/photo3.jpg" alt="Photo">--}}
                            {{--                                            </div>--}}
                            {{--                                            <!-- /.col -->--}}
                            {{--                                            <div class="col-sm-6">--}}
                            {{--                                                <img class="img-responsive" src="../../dist/img/photo4.jpg" alt="Photo">--}}
                            {{--                                                <br>--}}
                            {{--                                                <img class="img-responsive" src="../../dist/img/photo1.png" alt="Photo">--}}
                            {{--                                            </div>--}}
                            {{--                                            <!-- /.col -->--}}
                            {{--                                        </div>--}}
                            {{--                                        <!-- /.row -->--}}
                            {{--                                    </div>--}}
                            {{--                                    <!-- /.col -->--}}
                            {{--                                </div>--}}
                            {{--                                <!-- /.row -->--}}

                            {{--                                <ul class="list-inline">--}}
                            {{--                                    <li><a href="#" class="link-black text-sm"><i class="fa fa-share margin-r-5"></i>--}}
                            {{--                                            Share</a></li>--}}
                            {{--                                    <li><a href="#" class="link-black text-sm"><i--}}
                            {{--                                                class="fa fa-thumbs-o-up margin-r-5"></i> Like</a>--}}
                            {{--                                    </li>--}}
                            {{--                                    <li class="pull-right">--}}
                            {{--                                        <a href="#" class="link-black text-sm"><i--}}
                            {{--                                                class="fa fa-comments-o margin-r-5"></i> Comments--}}
                            {{--                                            (5)</a></li>--}}
                            {{--                                </ul>--}}

                            {{--                                <input class="form-control input-sm" type="text" placeholder="Type a comment">--}}
                            {{--                            </div>--}}
                            {{--                            <!-- /.post -->--}}
                        </div>
                        <!-- /.tab-pane -->
                    {{--                        <div class="tab-pane" id="timeline">--}}
                    {{--                            <!-- The timeline -->--}}
                    {{--                            <ul class="timeline timeline-inverse">--}}
                    {{--                                <!-- timeline time label -->--}}
                    {{--                                <li class="time-label">--}}
                    {{--                        <span class="bg-red">--}}
                    {{--                          10 Feb. 2014--}}
                    {{--                        </span>--}}
                    {{--                                </li>--}}
                    {{--                                <!-- /.timeline-label -->--}}
                    {{--                                <!-- timeline item -->--}}
                    {{--                                <li>--}}
                    {{--                                    <i class="fa fa-envelope bg-blue"></i>--}}

                    {{--                                    <div class="timeline-item">--}}
                    {{--                                        <span class="time"><i class="fa fa-clock-o"></i> 12:05</span>--}}

                    {{--                                        <h3 class="timeline-header"><a href="#">Support Team</a> sent you an email</h3>--}}

                    {{--                                        <div class="timeline-body">--}}
                    {{--                                            Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles,--}}
                    {{--                                            weebly ning heekya handango imeem plugg dopplr jibjab, movity--}}
                    {{--                                            jajah plickers sifteo edmodo ifttt zimbra. Babblely odeo kaboodle--}}
                    {{--                                            quora plaxo ideeli hulu weebly balihoo...--}}
                    {{--                                        </div>--}}
                    {{--                                        <div class="timeline-footer">--}}
                    {{--                                            <a class="btn btn-primary btn-xs">Read more</a>--}}
                    {{--                                            <a class="btn btn-danger btn-xs">Delete</a>--}}
                    {{--                                        </div>--}}
                    {{--                                    </div>--}}
                    {{--                                </li>--}}
                    {{--                                <!-- END timeline item -->--}}
                    {{--                                <!-- timeline item -->--}}
                    {{--                                <li>--}}
                    {{--                                    <i class="fa fa-user bg-aqua"></i>--}}

                    {{--                                    <div class="timeline-item">--}}
                    {{--                                        <span class="time"><i class="fa fa-clock-o"></i> 5 mins ago</span>--}}

                    {{--                                        <h3 class="timeline-header no-border"><a href="#">Sarah Young</a> accepted your--}}
                    {{--                                            friend request--}}
                    {{--                                        </h3>--}}
                    {{--                                    </div>--}}
                    {{--                                </li>--}}
                    {{--                                <!-- END timeline item -->--}}
                    {{--                                <!-- timeline item -->--}}
                    {{--                                <li>--}}
                    {{--                                    <i class="fa fa-comments bg-yellow"></i>--}}

                    {{--                                    <div class="timeline-item">--}}
                    {{--                                        <span class="time"><i class="fa fa-clock-o"></i> 27 mins ago</span>--}}

                    {{--                                        <h3 class="timeline-header"><a href="#">Jay White</a> commented on your post--}}
                    {{--                                        </h3>--}}

                    {{--                                        <div class="timeline-body">--}}
                    {{--                                            Take me to your leader!--}}
                    {{--                                            Switzerland is small and neutral!--}}
                    {{--                                            We are more like Germany, ambitious and misunderstood!--}}
                    {{--                                        </div>--}}
                    {{--                                        <div class="timeline-footer">--}}
                    {{--                                            <a class="btn btn-warning btn-flat btn-xs">View comment</a>--}}
                    {{--                                        </div>--}}
                    {{--                                    </div>--}}
                    {{--                                </li>--}}
                    {{--                                <!-- END timeline item -->--}}
                    {{--                                <!-- timeline time label -->--}}
                    {{--                                <li class="time-label">--}}
                    {{--                        <span class="bg-green">--}}
                    {{--                          3 Jan. 2014--}}
                    {{--                        </span>--}}
                    {{--                                </li>--}}
                    {{--                                <!-- /.timeline-label -->--}}
                    {{--                                <!-- timeline item -->--}}
                    {{--                                <li>--}}
                    {{--                                    <i class="fa fa-camera bg-purple"></i>--}}

                    {{--                                    <div class="timeline-item">--}}
                    {{--                                        <span class="time"><i class="fa fa-clock-o"></i> 2 days ago</span>--}}

                    {{--                                        <h3 class="timeline-header"><a href="#">Mina Lee</a> uploaded new photos</h3>--}}

                    {{--                                        <div class="timeline-body">--}}
                    {{--                                            <img src="http://placehold.it/150x100" alt="..." class="margin">--}}
                    {{--                                            <img src="http://placehold.it/150x100" alt="..." class="margin">--}}
                    {{--                                            <img src="http://placehold.it/150x100" alt="..." class="margin">--}}
                    {{--                                            <img src="http://placehold.it/150x100" alt="..." class="margin">--}}
                    {{--                                        </div>--}}
                    {{--                                    </div>--}}
                    {{--                                </li>--}}
                    {{--                                <!-- END timeline item -->--}}
                    {{--                                <li>--}}
                    {{--                                    <i class="fa fa-clock-o bg-gray"></i>--}}
                    {{--                                </li>--}}
                    {{--                            </ul>--}}
                    {{--                        </div>--}}
                    <!-- /.tab-pane -->

                        <div class="tab-pane" id="settings">

                            {!! Form::model(Auth::user(), ['route' => ['profile.update'], 'method' => 'patch', 'enctype' => 'multipart/form-data', 'class' => 'form-horizontal']) !!}

                            <div class="form-group">
                                <label for="first_name" class="col-sm-2 control-label">نام</label>

                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="first_name"
                                           placeholder="{{ Auth::user()->first_name}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="last_name" class="col-sm-2 control-label">نام خانوادگی</label>

                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="last_name"
                                           placeholder="{{ Auth::user()->last_name}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="email" class="col-sm-2 control-label ">پست الکترونیک</label>

                                <div class="col-sm-10">
                                    <input disabled type="email" class="form-control text-ltr" id="email"
                                           placeholder="{{ Auth::user()->email }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="username" class="col-sm-2 control-label">نام کاربری</label>

                                <div class="col-sm-10">
                                    <input disabled type="text" class="form-control text-ltr" id="username"
                                           placeholder="{{ Auth::user()->username }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="password" class="col-sm-2 control-label">رمز عبور</label>

                                <div class="col-sm-10">
                                    <input type="password" class="form-control" name="password" placeholder="رمز عبور">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="confirm_password" class="col-sm-2 control-label">تکرار رمز عبور</label>

                                <div class="col-sm-10">
                                    <input type="password" class="form-control" name="confirm_password"
                                           placeholder="تکرار رمز عبور">
                                </div>
                            </div>
                            <!-- Avatar Path Field -->
                            <div class="form-group">
                                <div class="col-sm-2 control-label">
                                    {!! Form::label('avatar_path', 'تصویر شخصی:') !!}
                                </div>
                                <div class="col-md-10">
                                    <input type="file" name="avatar_path" class="form-control custom-file-input"
                                           id="customFile">
                                    <label style="margin: 10px" class="form-control custom-file-label"
                                           for="customFile"></label>
                                </div>
                            </div>
                            {{--                                <div class="form-group">--}}
                            {{--                                    <label for="inputExperience" class="col-sm-2 control-label">Experience</label>--}}

                            {{--                                    <div class="col-sm-10">--}}
                            {{--                                        <textarea class="form-control" id="inputExperience"--}}
                            {{--                                                  placeholder="Experience"></textarea>--}}
                            {{--                                    </div>--}}
                            {{--                                </div>--}}
                            {{--                                <div class="form-group">--}}
                            {{--                                    <div class="col-sm-offset-2 col-sm-10">--}}
                            {{--                                        <div class="checkbox">--}}
                            {{--                                            <label>--}}
                            {{--                                                <input type="checkbox"> I agree to the <a href="#">terms and--}}
                            {{--                                                    conditions</a>--}}
                            {{--                                            </label>--}}
                            {{--                                        </div>--}}
                            {{--                                    </div>--}}
                            {{--                                </div>--}}
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <button type="submit" class="btn btn-danger">ذخیره</button>
                                </div>
                            </div>

                            {!! Form::close() !!}
                        </div>
                        <!-- /.tab-pane -->
                    </div>
                    <!-- /.tab-content -->
                </div>
                <!-- /.nav-tabs-custom -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->

    </section>
@endsection
