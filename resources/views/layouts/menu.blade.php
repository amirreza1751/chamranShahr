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

<li class="{{ Request::is('terms*') ? 'active' : '' }}">
    <a href="{!! route('terms.index') !!}"><i class="fa fa-edit"></i><span>Terms</span></a>
</li>

<li class="{{ Request::is('studyLevels*') ? 'active' : '' }}">
    <a href="{!! route('studyLevels.index') !!}"><i class="fa fa-edit"></i><span>Study Levels</span></a>
</li>

<li class="{{ Request::is('adTypes*') ? 'active' : '' }}">
    <a href="{{ route('adTypes.index') }}"><i class="fa fa-edit"></i><span>Ad Types</span></a>
</li>

<li class="{{ Request::is('categories*') ? 'active' : '' }}">
    <a href="{{ route('categories.index') }}"><i class="fa fa-edit"></i><span>Categories</span></a>
</li>

<li class="{{ Request::is('ads*') ? 'active' : '' }}">
    <a href="{{ route('ads.index') }}"><i class="fa fa-edit"></i><span>Ads</span></a>
</li>

<li class="{{ Request::is('bookEditions*') ? 'active' : '' }}">
    <a href="{{ route('bookEditions.index') }}"><i class="fa fa-edit"></i><span>Book Editions</span></a>
</li>

<li class="{{ Request::is('bookLanguages*') ? 'active' : '' }}">
    <a href="{{ route('bookLanguages.index') }}"><i class="fa fa-edit"></i><span>Book Languages</span></a>
</li>

<li class="{{ Request::is('bookSizes*') ? 'active' : '' }}">
    <a href="{{ route('bookSizes.index') }}"><i class="fa fa-edit"></i><span>Book Sizes</span></a>
</li>

