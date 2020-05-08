<li class="{{ Request::is('users*') ? 'active' : '' }}">
    <a href="{!! route('users.index') !!}"><i class="fa fa-edit"></i><span>کاربران</span></a>
</li>

<li class="{{ Request::is('roles*') ? 'active' : '' }}">
    <a href="{!! route('roles.index') !!}"><i class="fa fa-edit"></i><span>Roles</span></a>
</li>

<li class="{{ Request::is('permissions*') ? 'active' : '' }}">
    <a href="{!! route('permissions.index') !!}"><i class="fa fa-edit"></i><span>Permissions</span></a>
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

<li class="{{ Request::is('books*') ? 'active' : '' }}">
    <a href="{{ route('books.index') }}"><i class="fa fa-edit"></i><span>Books</span></a>
</li>

<li class="{{ Request::is('manageLevels*') ? 'active' : '' }}">
    <a href="{!! route('manageLevels.index') !!}"><i class="fa fa-edit"></i><span>Manage Levels</span></a>
</li>

<li class="{{ Request::is('manageHierarchies*') ? 'active' : '' }}">
    <a href="{!! route('manageHierarchies.index') !!}"><i class="fa fa-edit"></i><span>Manage Hierarchies</span></a>
</li>


<li class="{{ Request::is('departments*') ? 'active' : '' }}">
    <a href="{!! route('departments.index') !!}"><i class="fa fa-edit"></i><span>Departments</span></a>
</li>

<li class="{{ Request::is('faculties*') ? 'active' : '' }}">
    <a href="{!! route('faculties.index') !!}"><i class="fa fa-edit"></i><span>Faculties</span></a>
</li>

<li class="{{ Request::is('studyFields*') ? 'active' : '' }}">
    <a href="{!! route('studyFields.index') !!}"><i class="fa fa-edit"></i><span>Study Fields</span></a>
</li>

<li class="{{ Request::is('studyAreas*') ? 'active' : '' }}">
    <a href="{!! route('studyAreas.index') !!}"><i class="fa fa-edit"></i><span>Study Areas</span></a>
</li>

<li class="{{ Request::is('studyStatuses*') ? 'active' : '' }}">
    <a href="{!! route('studyStatuses.index') !!}"><i class="fa fa-edit"></i><span>Study Statuses</span></a>
</li>

<li class="{{ Request::is('students*') ? 'active' : '' }}">
    <a href="{!! route('students.index') !!}"><i class="fa fa-edit"></i><span>Students</span></a>
</li>

<li class="{{ Request::is('manageHistories*') ? 'active' : '' }}">
    <a href="{!! route('manageHistories.index') !!}"><i class="fa fa-edit"></i><span>Manage Histories</span></a>
</li>



<li class="{{ Request::is('externalServiceTypes*') ? 'active' : '' }}">
    <a href="{!! route('externalServiceTypes.index') !!}"><i class="fa fa-edit"></i><span>External Service Types</span></a>
</li>

<li class="{{ Request::is('externalServices*') ? 'active' : '' }}">
    <a href="{!! route('externalServices.index') !!}"><i class="fa fa-edit"></i><span>External Services</span></a>
</li>

