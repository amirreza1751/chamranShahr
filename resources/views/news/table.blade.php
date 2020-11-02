<div class="table-responsive">
    <table class="table" id="news-table">
        <thead>
        <tr>
            <th>عنوان</th>
            <th>پیوند</th>
            <th>توضیحات</th>
            <th colspan="3" style="min-width: 12rem">اقدامات</th>
        </tr>
        </thead>
        <tbody>
        @foreach($news as $news)
            <tr>
                <td><strong>{!! $news->title !!}</strong></td>
            <td><a href="{!! $news->link !!}" target="_blank">بازدید</a></td>
            <td>{!! mb_substr($news->description, 0, 142, "utf-8") . '...' !!}</td>
                <td>
                    {!! Form::open(['route' => ['news.destroy', $news->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{!! route('news.show', [$news->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                        <a href="{!! route('news.edit', [$news->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                        <a data-toggle="tooltip" title="ایجاد نوتیفیکیشن" href="{!! route('notifications.showNotifyFromNotifier', [App\Models\News::class, $news->id]) !!}" class='btn btn-info btn-xs'><i class="fa fa-bell"></i></a>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('از حذف این خبر مطمئن هستید؟')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
