<li class="{{ Request::is('home') ? 'active' : '' }}">
    <a href="{!! route('home') !!}"><i class="fa fa-dashboard"></i><span>داشبورد</span></a>
</li>

<li class="{{ Request::is('profile*') ? 'active' : '' }}">
    <a href="{!! route('profile') !!}"><i class="fa fa-user-circle"></i><span>صفحه‌ی شخصی</span></a>
</li>

<li class="treeview" style="height: auto;">
    <a href="#"><i class="fa fa-wrench"></i> ابزارها
        <span class="pull-left-container">
                  <i class="fa fa-angle-left pull-left"></i>
                </span>
    </a>
    <ul class="treeview-menu" style="display: none;">
        <li><a href="{!! 'api/documentation?token='. credentials('SWAGGER_DOCS_TOKEN')  !!}"><i class="fa fa-file-text"></i><span class="title-secondary">داکیومنتیشن سوگر</span></a></li>
        <li><a href="https://gitlab.com/leviathann/chamran-shahr"><i class="fa fa-gitlab"></i><span class="title-secondary">ریپوزیتوری گیت سورس فرانت‌اند</span></a></li>
        <li><a href="https://git.parscoders.com/theAmD/chamranshahr"><i class="fa fa-git"></i><span class="title-secondary">ریپوزیتوری گیت سورس بک‌اند</span></a></li>
        <li><a href="https://chamranshahr.postman.co/"><i class="fa fa-code"></i><span class="title-secondary">تیم چمران‌شهر در پست‌من</span></a></li>
    </ul>
</li>

<li>
    <a href="{!! route('logout') !!}" class="btn-danger" style="color: white;" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
        <i class="fa fa-sign-out"></i><span>خروج</span></a>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        {{ csrf_field() }}
    </form>
</li>

