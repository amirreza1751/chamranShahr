<div class="table-responsive">
    <table class="table" id="notificationSamples-table">
        <thead>
        <tr>
            <th>عنوان</th>
            <th>توضیحات</th>
            <th style="min-width: 10rem">نوع</th>
            <th>منبع</th>
            <th style="min-width: 10rem">تاریخ انقضا</th>
            <th colspan="3" style="min-width: 10rem">اقدام</th>
        </tr>
        </thead>
        <tbody>
        @foreach($notificationSamples as $notificationSample)
            <tr>
                <td>{{ $notificationSample->title }}</td>
                <td>{{ $notificationSample->brief_description }}</td>
                <td>{{ $notification_types[$notificationSample->type] }}</td>
                <td><a href="{!! route(app($notificationSample->notifier_type)->getTable() . '.show', ['id' => $notificationSample->notifier_id]) !!}" class=' btn-success btn-xs'>مشاهده</a></td>
                <td @if($notificationSample->deadline < Carbon\Carbon::now()) data-toggle="tooltip" title="منقضی شده" class="bg-danger" @endif>
                    @if (isset($notificationSample->deadline))
                        {{ Morilog\Jalali\Jalalian::fromDateTime($notificationSample->deadline)->format('%A, %d %B %Y') }}
                    @endif
                </td>
                <td>
                    {!! Form::open(['route' => ['notificationSamples.destroy', $notificationSample->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('notificationSamples.show', [$notificationSample->id]) }}"
                           class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                        <a href="{{ route('notificationSamples.edit', [$notificationSample->id]) }}"
                           class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('آیا از حذف این نوتیفیکیشن اطمینان دارید؟')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
