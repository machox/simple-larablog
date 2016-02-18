<!-- Left side column. contains the sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar Menu -->
        <ul class="sidebar-menu">
            <li class="header">NAVIGATION</li>
            <li class="treeview">
                <a href="#"><span>Posts</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="{{ url('post') }}"><i class="fa fa-btn fa-bars"> Posts</i></a></li>
                    <li><a href="{{ url('post/create') }}"><i class="fa fa-btn fa-plus"> Add Post</i></a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#"><span>Categories</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="{{ url('category') }}"><i class="fa fa-btn fa-bars"> Categories</i></a></li>
                    <li><a href="{{ url('category/create') }}"><i class="fa fa-btn fa-plus"> Add Category</i></a></li>
                </ul>
            </li>
        </ul><!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>