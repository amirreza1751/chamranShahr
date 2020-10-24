<div class="col-md-2">
</div>

<div class="col-md-8">
    <section>
        <!-- Widget: user widget style 1 -->
        <div class="box box-widget widget-user widget-user-custom">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <a href="{{ $notification->notifier->absolute_path }}">
                <div class="widget-user-header widget-user-header-custom bg-black" style="background: url({{ $notification->notifier->absolute_path }}) center center; background-repeat: no-repeat;">
                    <h3 class="widget-user-username widget-user-username-custom">{{ $notification->title }}</h3>
{{--                    <h5 class="widget-user-desc">Web Designer</h5>--}}
                </div>
            </a>
{{--            <div class="widget-user-image">--}}
{{--                <img class="img-circle" src="{{ Auth::user()->avatar() }}" alt="User Avatar">--}}
{{--            </div>--}}
            <div class="box-footer">
                <div class="row">
                    <div class="col-sm-4 border-right">
                        <div class="description-block">
                            <h5 class="description-header">3,200</h5>
                            <span class="description-text">SALES</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-4 border-right">
                        <div class="description-block">
                            <h5 class="description-header">13,000</h5>
                            <span class="description-text">FOLLOWERS</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-4">
                        <div class="description-block">
                            <h5 class="description-header">35</h5>
                            <span class="description-text">PRODUCTS</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
        </div>
        <!-- /.widget-user -->
    </section>
</div>

<div class="col-md-2">
</div>

{{--<!-- Id Field -->--}}
{{--<div class="form-group">--}}
{{--    {!! Form::label('id', 'Id:') !!}--}}
{{--    <p>{!! $notification->id !!}</p>--}}
{{--</div>--}}

{{--<!-- Title Field -->--}}
{{--<div class="form-group">--}}
{{--    {!! Form::label('title', 'Title:') !!}--}}
{{--    <p>{!! $notification->title !!}</p>--}}
{{--</div>--}}

{{--<!-- Brief Description Field -->--}}
{{--<div class="form-group">--}}
{{--    {!! Form::label('brief_description', 'Brief Description:') !!}--}}
{{--    <p>{!! $notification->brief_description !!}</p>--}}
{{--</div>--}}

{{--<!-- Type Field -->--}}
{{--<div class="form-group">--}}
{{--    {!! Form::label('type', 'Type:') !!}--}}
{{--    <p>{!! $notification->type !!}</p>--}}
{{--</div>--}}

{{--<!-- Notifiable Type Field -->--}}
{{--<div class="form-group">--}}
{{--    {!! Form::label('notifiable_type', 'Notifiable Type:') !!}--}}
{{--    <p>{!! $notification->notifiable_type !!}</p>--}}
{{--</div>--}}

{{--<!-- Notifiable Id Field -->--}}
{{--<div class="form-group">--}}
{{--    {!! Form::label('notifiable_id', 'Notifiable Id:') !!}--}}
{{--    <p>{!! $notification->notifiable_id !!}</p>--}}
{{--</div>--}}

{{--<!-- Notifier Type Field -->--}}
{{--<div class="form-group">--}}
{{--    {!! Form::label('notifier_type', 'Notifier Type:') !!}--}}
{{--    <p>{!! $notification->notifier_type !!}</p>--}}
{{--</div>--}}

{{--<!-- Notifier Id Field -->--}}
{{--<div class="form-group">--}}
{{--    {!! Form::label('notifier_id', 'Notifier Id:') !!}--}}
{{--    <p>{!! $notification->notifier_id !!}</p>--}}
{{--</div>--}}

{{--<!-- Deadline Field -->--}}
{{--<div class="form-group">--}}
{{--    {!! Form::label('deadline', 'Deadline:') !!}--}}
{{--    <p>{!! $notification->deadline !!}</p>--}}
{{--</div>--}}

{{--<!-- Data Field -->--}}
{{--<div class="form-group">--}}
{{--    {!! Form::label('data', 'Data:') !!}--}}
{{--    <p>{!! $notification->data !!}</p>--}}
{{--</div>--}}

{{--<!-- Read At Field -->--}}
{{--<div class="form-group">--}}
{{--    {!! Form::label('read_at', 'Read At:') !!}--}}
{{--    <p>{!! $notification->read_at !!}</p>--}}
{{--</div>--}}

{{--<!-- Created At Field -->--}}
{{--<div class="form-group">--}}
{{--    {!! Form::label('created_at', 'Created At:') !!}--}}
{{--    <p>{!! $notification->created_at !!}</p>--}}
{{--</div>--}}

{{--<!-- Updated At Field -->--}}
{{--<div class="form-group">--}}
{{--    {!! Form::label('updated_at', 'Updated At:') !!}--}}
{{--    <p>{!! $notification->updated_at !!}</p>--}}
{{--</div>--}}

{{--<!-- Deleted At Field -->--}}
{{--<div class="form-group">--}}
{{--    {!! Form::label('deleted_at', 'Deleted At:') !!}--}}
{{--    <p>{!! $notification->deleted_at !!}</p>--}}
{{--</div>--}}

