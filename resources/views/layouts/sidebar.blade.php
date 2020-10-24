<aside class="main-sidebar" id="sidebar-wrapper">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar user panel (optional) -->
        <div class="user-panel">
            <div class="pull-right image">
                <img src="{{ Auth::user()->avatar() }}" class="img-circle"
                     alt="User Image"/>
            </div>
            <div class="pull-right info">
                @if (Auth::guest())
                    <p>چمران‌شهر</p>
                @else
                    <p>{{ Auth::user()->full_name}}</p>
            @endif
            <!-- Status -->
                <a href="#"><i class="fa fa-circle text-success"></i> آنلاین</a>
            </div>
        </div>

        <!-- search form (Optional) -->
        <form method="get" class="sidebar-form">
            <div class="input-group">
                <input disabled="disabled" type="text" name="q" class="form-control" placeholder="جست‌وجو..."/>
                <span class="input-group-btn">
                    <button disabled="disabled" {{-- type='submit' --}} name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i>
                    </button>
                </span>
            </div>
        </form>
        <!-- Sidebar Menu -->

        <ul class="sidebar-menu" data-widget="tree">
            @if(Auth::user()->hasRole('developer'))
                @include('layouts.menu')
            @elseif(Auth::user()->hasRole('manager'))
                @include('layouts.manager_menu')
            @else
                @include('layouts.basic_menu')
            @endif

        </ul>
        <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>
