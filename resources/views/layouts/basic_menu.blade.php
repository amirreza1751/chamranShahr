<li class="{{ Request::is('profile*') ? 'active' : '' }}">
    <a href="{!! route('notices.index') !!}"><i class="fa fa-user-circle"></i><span>صفحه‌ی شخصی</span></a>
</li>

<li>
    <a href="{!! route('logout') !!}" class="btn-danger" style="color: white;" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
        <i class="fa fa-sign-out"></i><span>خروج</span></a>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        {{ csrf_field() }}
    </form>
</li>
