<li class="{{ Request::is('users*') ? 'active' : '' }}">
    <a href="{!! route('users.index') !!}"><i class="fa fa-edit"></i><span>Users</span></a>
</li>

<li class="{{ Request::is('locations*') ? 'active' : '' }}">
    <a href="{!! route('locations.index') !!}"><i class="fa fa-edit"></i><span>Locations</span></a>
</li>

<li class="{{ Request::is('media*') ? 'active' : '' }}">
    <a href="{!! route('media.index') !!}"><i class="fa fa-edit"></i><span>Media</span></a>
</li>

<li class="{{ Request::is('news*') ? 'active' : '' }}">
    <a href="{!! route('news.index') !!}"><i class="fa fa-edit"></i><span>News</span></a>
</li>

<li class="{{ Request::is('notifications*') ? 'active' : '' }}">
    <a href="{!! route('notifications.index') !!}"><i class="fa fa-edit"></i><span>Notifications</span></a>
</li>

<li class="{{ Request::is('notices*') ? 'active' : '' }}">
    <a href="{!! route('notices.index') !!}"><i class="fa fa-edit"></i><span>Notices</span></a>
</li>

<li class="{{ Request::is('genders*') ? 'active' : '' }}">
    <a href="{!! route('genders.index') !!}"><i class="fa fa-edit"></i><span>Genders</span></a>
</li>

