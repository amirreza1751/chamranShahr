<li class="{{ Request::is('home') ? 'active' : '' }}">
    <a href="{!! route('home') !!}"><i class="fa fa-dashboard"></i><span>داشبورد</span></a>
</li>

<li class="{{ Request::is('profile*') ? 'active' : '' }}">
    <a href="{!! route('profile') !!}"><i class="fa fa-user-circle"></i><span>صفحه‌ی شخصی</span></a>
</li>

{{--<li class="{{ Request::is('notifications*') ? 'active' : '' }}">--}}
{{--    <a href="{!! route('notifications.index') !!}"><i class="fa fa-bell"></i><span>مدیریت نوتیفیکیشن‌ها</span></a>--}}
{{--</li>--}}

<li class="{{ Request::is('notificationSamples*') ? 'active' : '' }}">
    <a href="{!! route('notificationSamples.index') !!}"><i class="fa fa-bell"></i><span>مدیریت نوتیفیکیشن‌ها</span></a>
</li>

<li class="{{ Request::is('departments*') ? 'active' : '' }}">
    <a href="{!! route('departments.index') !!}"><i class="fa fa-building"></i><span>مدیریت دپارتمان‌ها</span></a>
</li>

<li class="{{ Request::is('news*') ? 'active' : '' }}">
    <a href="{!! route('news.index') !!}"><i class="fa fa-newspaper-o"></i><span>مدیریت اخبار</span></a>
</li>

<li class="{{ Request::is('notices*') ? 'active' : '' }}">
    <a href="{!! route('notices.index') !!}"><i class="fa fa-sticky-note"></i><span>مدیریت اطلاعیه‌ها</span></a>
</li>

<li class="{{ Request::is('externalServices*') ? 'active' : '' }}">
    <a href="{!! route('externalServices.index') !!}"><i class="fa fa-rss-square"></i><span>مدیریت سرویس‌های خارجی</span></a>
</li>

<li>
    <a href="{!! url('/logout') !!}" class="btn-danger" style="color: white;" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
        <i class="fa fa-sign-out"></i><span>خروج</span></a>
    <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
        {{ csrf_field() }}
    </form>
</li>
