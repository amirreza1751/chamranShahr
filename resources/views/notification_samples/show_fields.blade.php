<!-- Id Field -->
<div class="form-group">
    {!! Form::label('id', 'Id:') !!}
    <p>{{ $notificationSample->id }}</p>
</div>

<!-- Title Field -->
<div class="form-group">
    {!! Form::label('title', 'Title:') !!}
    <p>{{ $notificationSample->title }}</p>
</div>

<!-- Brief Description Field -->
<div class="form-group">
    {!! Form::label('brief_description', 'Brief Description:') !!}
    <p>{{ $notificationSample->brief_description }}</p>
</div>

<!-- Type Field -->
<div class="form-group">
    {!! Form::label('type', 'Type:') !!}
    <p>{{ $notificationSample->type }}</p>
</div>

<!-- Notifier Type Field -->
<div class="form-group">
    {!! Form::label('notifier_type', 'Notifier Type:') !!}
    <p>{{ $notificationSample->notifier_type }}</p>
</div>

<!-- Notifier Id Field -->
<div class="form-group">
    {!! Form::label('notifier_id', 'Notifier Id:') !!}
    <p>{{ $notificationSample->notifier_id }}</p>
</div>

<!-- Deadline Field -->
<div class="form-group">
    {!! Form::label('deadline', 'Deadline:') !!}
    <p>{{ $notificationSample->deadline }}</p>
</div>

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $notificationSample->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $notificationSample->updated_at }}</p>
</div>

<!-- Deleted At Field -->
<div class="form-group">
    {!! Form::label('deleted_at', 'Deleted At:') !!}
    <p>{{ $notificationSample->deleted_at }}</p>
</div>

