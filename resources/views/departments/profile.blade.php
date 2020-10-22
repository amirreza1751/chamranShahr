@extends('layouts.app')

@section('content')
    <div class="container-fluid" style="padding: 0">
        <div class="content" style="padding: 0">
            @include('adminlte-templates::common.errors')
            @include('flash::message')
            <div class="col-sm-12">
                <div class="card box-cover">
                    <img class="card-img-top box-cover-img" src="{{ $department->path }}" alt="Card image">
                    <div class="card-body text-center">
                        <h4 class="card-title">@if(isset($department->title)) {{ $department->title }} @endif</h4>
                        <p class="card-text"><strong>نوع: @if(!is_null($department->manage_level)) {{ $department->manage_level->management_title }} @endif</strong></p>
                        <p class="card-text">مدیر: @if(!is_null($department->manager())) {{ $department->manager()->full_name }} @endif</p>
                        @can('updateProfile', $department)<a href="{{ route('departments.editProfile', [$department->id]) }}" class="btn btn-primary">ویرایش</a>@endcan
                    </div>
                </div>

                <!-- Description Field -->
                <div class="box-description">
                    <div class="col-lg-3 text-center">{!! Form::label('description', 'مختـــصـــری در ارتباط با مدیـــریــــــت', ['class' => 'box-description-title']) !!}</div>
                    <div class="col-lg-9 box-description-text"><span> @if(isset($department->description)) {{$department->description}} @endif </span></div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid" style="margin-top: 1rem">

        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs pull-right">
                <li class="active"><a href="#news" data-toggle="tab" aria-expanded="false">اخبار</a></li>
                <li class=""><a href="#notices" data-toggle="tab" aria-expanded="false">اطلاعیه‌ها</a></li>
                @can('updateProfile', $department)
                    <li class=""><a href="#settings" data-toggle="tab" aria-expanded="true">تنظیمات دپارتمان</a></li>
                @endcan
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="news">
                    @foreach($department->news as $single_news)
                        <div class="attachment-block clearfix">
                            <img class="attachment-img image-square-15" src="{{ $single_news->path }}"
                                 alt="Attachment Image">

                            <div class="attachment-pushed">
                                <h4 class="attachment-heading"><a>{{ $single_news->title }}</a></h4>

                                <div class="attachment-text text-justify">
                                    {{  $single_news->description }}
                                    <a href="{!! route('news.show', [ $single_news->id]) !!}">بیشتر</a>
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
                <div class="tab-pane" id="notices">
                    @foreach($department->notices as $notice)
                        <div class="attachment-block clearfix">
                            <img class="attachment-img image-square-15" src="{{ $notice->thumbnail }}"
                                 alt="Attachment Image">

                            <div class="attachment-pushed">
                                <h4 class="attachment-heading"><a>{{ $notice->title }}</a></h4>

                                <div class="attachment-text text-justify">
                                    {{  $notice->description }}
                                    <a href="{!! route('notices.show', [ $notice->id]) !!}">بیشتر</a>
                                </div>
                                <!-- /.attachment-text -->
                            </div>
                            <!-- /.attachment-pushed -->
                        </div>
                    @endforeach
                </div>

                <div class="tab-pane" id="settings">

                    {!! Form::model($department, ['route' => ['departments.updateProfile', $department->id], 'method' => 'patch', 'enctype' => 'multipart/form-data', 'class' => 'form-horizontal']) !!}

                    <div class="form-group">
                        <label for="title" class="col-sm-2 control-label">عنوان</label>

                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="title"
                                   placeholder="{{ $department->title}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="english_title" class="col-sm-2 control-label">عنوان انگلیسی</label>

                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="english_title"
                                   placeholder="{{ $department->english_title}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="description" class="col-sm-2 control-label">توضیحات</label>

                        <div class="col-sm-10">
                            <textarea class="form-control" name="description" rows="10"
                                      placeholder="{{ $department->description }}"></textarea>
                        </div>
                    </div>
                    <!-- Path Field -->
                    <div class="form-group">
                        <div class="col-sm-2 control-label">
                            {!! Form::label('path', 'تصویر:') !!}
                        </div>
                        <div class="col-md-10">
                            <input type="file" name="path" class="form-control custom-file-input"
                                   id="customFile">
                            <label style="margin: 10px" class="form-control custom-file-label"
                                   for="customFile"></label>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-1 pull-left">
                            <button type="submit" class="btn btn-danger">ذخیره</button>
                        </div>
                    </div>

                    {!! Form::close() !!}
                </div>
            <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
        </div>
    </div>


@endsection
