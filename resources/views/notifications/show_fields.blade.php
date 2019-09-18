<!-- Id Field -->
<div class="form-group">
    {!! Form::label('id', 'Id:') !!}
    <p>{!! $notification->id !!}</p>
</div>

<!-- Title Field -->
<div class="form-group">
    {!! Form::label('title', 'Title:') !!}
    <p>{!! $notification->title !!}</p>
</div>

<!-- Brief Description Field -->
<div class="form-group">
    {!! Form::label('brief_description', 'Brief Description:') !!}
    <p>{!! $notification->brief_description !!}</p>
</div>

<!-- Type Field -->
<div class="form-group">
    {!! Form::label('type', 'Type:') !!}
    <p>{!! $notification->type !!}</p>
</div>

<!-- Notifiable Type Field -->
<div class="form-group">
    {!! Form::label('notifiable_type', 'Notifiable Type:') !!}
    <p>{!! $notification->notifiable_type !!}</p>
</div>

<!-- Notifiable Id Field -->
<div class="form-group">
    {!! Form::label('notifiable_id', 'Notifiable Id:') !!}
    <p>{!! $notification->notifiable_id !!}</p>
</div>

<!-- Notifier Type Field -->
<div class="form-group">
    {!! Form::label('notifier_type', 'Notifier Type:') !!}
    <p>{!! $notification->notifier_type !!}</p>
</div>

<!-- Notifier Id Field -->
<div class="form-group">
    {!! Form::label('notifier_id', 'Notifier Id:') !!}
    <p>{!! $notification->notifier_id !!}</p>
</div>

<!-- Deadline Field -->
<div class="form-group">
    {!! Form::label('deadline', 'Deadline:') !!}
    <p>{!! $notification->deadline !!}</p>
</div>

<!-- Data Field -->
<div class="form-group">
    {!! Form::label('data', 'Data:') !!}
    <p>{!! $notification->data !!}</p>
</div>

<!-- Read At Field -->
<div class="form-group">
    {!! Form::label('read_at', 'Read At:') !!}
    <p>{!! $notification->read_at !!}</p>
</div>

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{!! $notification->created_at !!}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{!! $notification->updated_at !!}</p>
</div>

<!-- Deleted At Field -->
<div class="form-group">
    {!! Form::label('deleted_at', 'Deleted At:') !!}
    <p>{!! $notification->deleted_at !!}</p>
</div>

