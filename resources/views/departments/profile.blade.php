@extends('layouts.app')

@section('content')
    <section class="content-header">
        <ol class="breadcrumb top-0">
            <li><a href="{{ route('home') }}"><i class="fa fa-dashboard"></i>داشبورد</a></li>
            <li><a href="{{ route('departments.index') }}"><i class="fa fa-building"></i>مدیریت دپارتمان‌ها</a></li>
            <li class="active">دپارتمان {{ $department->title }}</li>
        </ol>
    </section>
    <div class="container-fluid" style="padding: 0">
        <div class="content" style="padding: 0">
            @include('adminlte-templates::common.errors')
            @include('flash::message')
            <div class="col-sm-12">
                <div class="card box-cover">
                    <img class="card-img-top box-cover-img" src="{{ $department->absolute_path }}" alt="Card image">
                    <div class="card-body text-center">
                        <h4 class="card-title">@if(isset($department->title)) {{ $department->title }} @endif</h4>
                        <p class="card-text"><strong>نوع: @if(!is_null($department->manage_level)) {{ $department->manage_level->management_title }} @endif</strong></p>
                        <p class="card-text">مدیر: @if(!is_null($department->manager())) {{ $department->manager()->full_name }} @endif</p>
{{--                        @can('updateProfile', $department)<a href="{{ route('departments.editProfile', [$department->id]) }}" class="btn btn-primary">ویرایش</a>@endcan--}}
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
                            <img class="attachment-img image-square-15" src="{{ $single_news->thumbnail }}"
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
