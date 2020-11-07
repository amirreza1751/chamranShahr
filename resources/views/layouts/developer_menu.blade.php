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
        <li><a href="{!! 'api/documentation?token='. credentials('SWAGGER_DOCS_TOKEN')  !!}"><i class="fa fa-file-text"></i><span class="title-secondary">داکیومنتیشن سوگر</span></a>
        </li>
        <li><a href="https://gitlab.com/leviathann/chamran-shahr"><i class="fa fa-gitlab"></i><span
                    class="title-secondary">ریپوزیتوری گیت سورس فرانت‌اند</span></a></li>
        <li><a href="https://git.parscoders.com/theAmD/chamranshahr"><i class="fa fa-git"></i><span
                    class="title-secondary">ریپوزیتوری گیت سورس بک‌اند</span></a></li>
        <li><a href="https://chamranshahr.postman.co/"><i class="fa fa-code"></i><span class="title-secondary">تیم چمران‌شهر در پست‌من</span></a>
        </li>
    </ul>
</li>

<li class="treeview" style="height: auto;">
    <a href="#"><i class="fa fa-cog"></i>پیکربندی سامانه و پایگاه داده
        <span class="pull-left-container">
                  <i class="fa fa-angle-left pull-left"></i>
                </span>
    </a>
    <ul class="treeview-menu" style="display: none">

        <li id="hide" style="" class="{{ Request::is('users*') ? 'active' : '' }}">
            <a href="{!! route('users.index') !!}"><i class="fa fa-users"></i><span class="title-secondary" >مدیریت کاربران</span></a>
        </li>

        <li class="{{ Request::is('roles*') ? 'active' : '' }}">
            <a href="{!! route('roles.index') !!}"><i class="fa fa-edit"></i><span class="title-secondary" >Roles</span></a>
        </li>

        <li class="{{ Request::is('permissions*') ? 'active' : '' }}">
            <a href="{!! route('permissions.index') !!}"><i class="fa fa-edit"></i><span class="title-secondary" >Permissions</span></a>
        </li>

        <li class="{{ Request::is('locations*') ? 'active' : '' }}">
            <a href="{!! route('locations.index') !!}"><i class="fa fa-edit"></i><span class="title-secondary" >Locations</span></a>
        </li>

        <li class="{{ Request::is('media*') ? 'active' : '' }}">
            <a href="{!! route('media.index') !!}"><i class="fa fa-edit"></i><span class="title-secondary" >Media</span></a>
        </li>

        <li class="{{ Request::is('news*') ? 'active' : '' }}">
            <a href="{!! route('news.index') !!}"><i class="fa fa-newspaper-o"></i><span class="title-secondary" >مدیریت اخبار</span></a>
        </li>

        <li class="{{ Request::is('notifications*') ? 'active' : '' }}">
            <a href="{!! route('notifications.index') !!}"><i class="fa fa-bell"></i><span class="title-secondary" >مدیریت نوتیفیکیشن‌ها</span></a>
        </li>

        <li class="{{ Request::is('notices*') ? 'active' : '' }}">
            <a href="{!! route('notices.index') !!}"><i class="fa fa-sticky-note"></i><span class="title-secondary" >مدیریت اطلاعیه‌ها</span></a>
        </li>

        <li class="{{ Request::is('genders*') ? 'active' : '' }}">
            <a href="{!! route('genders.index') !!}"><i class="fa fa-edit"></i><span class="title-secondary" >Genders</span></a>
        </li>

        <li class="{{ Request::is('terms*') ? 'active' : '' }}">
            <a href="{!! route('terms.index') !!}"><i class="fa fa-edit"></i><span class="title-secondary" >Terms</span></a>
        </li>

        <li class="{{ Request::is('studyLevels*') ? 'active' : '' }}">
            <a href="{!! route('studyLevels.index') !!}"><i class="fa fa-edit"></i><span class="title-secondary" >Study Levels</span></a>
        </li>

        <li class="{{ Request::is('adTypes*') ? 'active' : '' }}">
            <a href="{{ route('adTypes.index') }}"><i class="fa fa-edit"></i><span class="title-secondary" >Ad Types</span></a>
        </li>

        <li class="{{ Request::is('categories*') ? 'active' : '' }}">
            <a href="{{ route('categories.index') }}"><i class="fa fa-edit"></i><span class="title-secondary" >Categories</span></a>
        </li>

        <li class="{{ Request::is('ads*') ? 'active' : '' }}">
            <a href="{{ route('ads.index') }}"><i class="fa fa-edit"></i><span class="title-secondary" >Ads</span></a>
        </li>
        <li class="{{ Request::is('bookEditions*') ? 'active' : '' }}">
            <a href="{{ route('bookEditions.index') }}"><i class="fa fa-edit"></i><span class="title-secondary" >Book Editions</span></a>
        </li>

        <li class="{{ Request::is('bookLanguages*') ? 'active' : '' }}">
            <a href="{{ route('bookLanguages.index') }}"><i class="fa fa-edit"></i><span class="title-secondary" >Book Languages</span></a>
        </li>

        <li class="{{ Request::is('bookSizes*') ? 'active' : '' }}">
            <a href="{{ route('bookSizes.index') }}"><i class="fa fa-edit"></i><span class="title-secondary" >Book Sizes</span></a>
        </li>

        <li class="{{ Request::is('books*') ? 'active' : '' }}">
            <a href="{{ route('books.index') }}"><i class="fa fa-edit"></i><span class="title-secondary" >Books</span></a>
        </li>

        <li class="{{ Request::is('manageLevels*') ? 'active' : '' }}">
            <a href="{!! route('manageLevels.index') !!}"><i class="fa fa-edit"></i><span class="title-secondary" >Manage Levels</span></a>
        </li>

        <li class="{{ Request::is('manageHierarchies*') ? 'active' : '' }}">
            <a href="{!! route('manageHierarchies.index') !!}"><i class="fa fa-edit"></i><span class="title-secondary" >Manage Hierarchies</span></a>
        </li>


        <li class="{{ Request::is('departments*') ? 'active' : '' }}">
            <a href="{!! route('departments.index') !!}"><i class="fa fa-building"></i><span class="title-secondary" >مدیریت دپارتمان‌ها</span></a>
        </li>

        <li class="{{ Request::is('faculties*') ? 'active' : '' }}">
            <a href="{!! route('faculties.index') !!}"><i class="fa fa-edit"></i><span class="title-secondary" >Faculties</span></a>
        </li>

        <li class="{{ Request::is('studyFields*') ? 'active' : '' }}">
            <a href="{!! route('studyFields.index') !!}"><i class="fa fa-edit"></i><span class="title-secondary" >Study Fields</span></a>
        </li>

        <li class="{{ Request::is('studyAreas*') ? 'active' : '' }}">
            <a href="{!! route('studyAreas.index') !!}"><i class="fa fa-edit"></i><span class="title-secondary" >Study Areas</span></a>
        </li>

        <li class="{{ Request::is('studyStatuses*') ? 'active' : '' }}">
            <a href="{!! route('studyStatuses.index') !!}"><i class="fa fa-edit"></i><span class="title-secondary" >Study Statuses</span></a>
        </li>

        <li class="{{ Request::is('students*') ? 'active' : '' }}">
            <a href="{!! route('students.index') !!}"><i class="fa fa-edit"></i><span class="title-secondary" >Students</span></a>
        </li>

        <li class="{{ Request::is('manageHistories*') ? 'active' : '' }}">
            <a href="{!! route('manageHistories.index') !!}"><i class="fa fa-edit"></i><span class="title-secondary" >Manage Histories</span></a>
        </li>


        <li class="{{ Request::is('externalServiceTypes*') ? 'active' : '' }}">
            <a href="{!! route('externalServiceTypes.index') !!}"><i
                    class="fa fa-edit"></i><span class="title-secondary" >External Service Types</span></a>
        </li>

        <li class="{{ Request::is('externalServices*') ? 'active' : '' }}">
            <a href="{!! route('externalServices.index') !!}"><i
                    class="fa fa-rss-square"></i><span class="title-secondary" >مدیریت سرویس‌های خارجی</span></a>
        </li>

        <li class="{{ Request::is('notificationSamples*') ? 'active' : '' }}">
            <a href="{{ route('notificationSamples.index') }}"><i
                    class="fa fa-edit"></i><span class="title-secondary" >Notification Samples</span></a>
        </li>
    </ul>
</li>

<li>
    <a href="{!! url('/logout') !!}" class="btn-danger" style="color: white;"
       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
        <i class="fa fa-sign-out"></i><span>خروج</span></a>
    <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
        {{ csrf_field() }}
    </form>
</li>

