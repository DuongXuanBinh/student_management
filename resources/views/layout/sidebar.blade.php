<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar user panel (optional) -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p> @if(Auth::user()->hasRole('admin'))
                        {{__('Admin')}}
                    @elseif(Auth::user()->hasRole('student'))
                        {{ucfirst(Auth::user()->student->name)}}
                    @endif
                </p>
                <!-- Status -->
                <a href="#"><i class="fa fa-circle text-success"></i>{{__('Online')}}</a>
            </div>
        </div>

        <!-- search form (Optional) -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search...">
                <span class="input-group-btn">
              <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
              </button>
            </span>
            </div>
        </form>
        <!-- /.search form -->

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">{{__('HEADER')}}</li>
            <!-- Optionally, you can add icons to the links -->
            <li class="{{(request()->segment(1)=='students') ? 'active' : ''}}"><a href="{{ route('students.index') }}"><i class="fa fa-link"></i> <span>{{__('Students')}}</span></a></li>
            <li class="{{(request()->segment(1)=='departments') ? 'active' : ''}}"><a href="{{ route('departments.index') }}" ><i class="fa fa-link"></i> <span>{{__('Departments')}}</span></a></li>
            <li class="{{(request()->segment(1)=='subjects') ? 'active' : ''}}"><a href="{{ route('subjects.index') }}"><i class="fa fa-link"></i> <span>{{__('Subjects')}}</span></a></li>
{{--            <li class="{{(request()->segment(1)=='results') ? 'active' : ''}}"><a href="{{ route('results.index') }}"><i class="fa fa-link"></i> <span>{{__('Results')}}</span></a></li>--}}
        </ul>
        <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>
