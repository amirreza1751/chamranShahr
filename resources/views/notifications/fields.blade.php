<!-- Title Field -->
<div class="form-group col-sm-6">
    {!! Form::label('title', 'Title:') !!}
    {!! Form::text('title', null, ['class' => 'form-control']) !!}
</div>

<!-- Brief Description Field -->
<div class="form-group col-sm-6">
    {!! Form::label('brief_description', 'Brief Description:') !!}
    {!! Form::text('brief_description', null, ['class' => 'form-control']) !!}
</div>

<!-- Type Field -->
<div class="form-group col-sm-6">
    {!! Form::label('type', 'Type:') !!}
    {!! Form::text('type', null, ['class' => 'form-control']) !!}
</div>

<!-- Notifiable Type Field -->
<div class="form-group col-sm-6">
    {!! Form::label('notifiable_type', 'Notifiable Type:') !!}
    {!! Form::text('notifiable_type', null, ['class' => 'form-control']) !!}
</div>

<!-- Notifiable Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('notifiable_id', 'Notifiable Id:') !!}
    {!! Form::number('notifiable_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Notifier Type Field -->
<div class="form-group col-sm-6">
    {!! Form::label('notifier_type', 'Notifier Type:') !!}
    {!! Form::text('notifier_type', null, ['class' => 'form-control']) !!}
</div>

<!-- Notifier Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('notifier_id', 'Notifier Id:') !!}
    {!! Form::number('notifier_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Deadline Field -->
<div class="form-group col-sm-6">
    {!! Form::label('deadline', 'Deadline:') !!}
    {!! Form::date('deadline', null, ['class' => 'form-control','id'=>'deadline']) !!}
</div>

@section('scripts')
    <script type="text/javascript">
        $('#deadline').datetimepicker({
            format: 'YYYY-MM-DD HH:mm:ss',
            useCurrent: false
        })
    </script>
@endsection

<!-- Data Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('data', 'Data:') !!}
    {!! Form::textarea('data', null, ['class' => 'form-control']) !!}
</div>

<!-- Read At Field -->
<div class="form-group col-sm-6">
    {!! Form::label('read_at', 'Read At:') !!}
    {!! Form::date('read_at', null, ['class' => 'form-control','id'=>'read_at']) !!}
</div>

@section('scripts')
    <script type="text/javascript">
        $('#read_at').datetimepicker({
            format: 'YYYY-MM-DD HH:mm:ss',
            useCurrent: false
        })
    </script>
@endsection

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('notifications.index') !!}" class="btn btn-default">Cancel</a>
</div>
