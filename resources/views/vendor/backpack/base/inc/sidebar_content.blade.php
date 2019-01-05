<!-- This file is used to store sidebar items, starting with Backpack\Base 0.9.0 -->
<li><a href="{{ backpack_url('dashboard') }}"><i class="fa fa-dashboard"></i> <span>{{ trans('backpack::base.dashboard') }}</span></a></li>
<li><a href="{{ backpack_url('elfinder') }}"><i class="fa fa-files-o"></i> <span>{{ trans('backpack::crud.file_manager') }}</span></a></li>
<li><a href='{{ url(config('backpack.base.route_prefix', 'admin') . '/setting') }}'><i class='fa fa-cog'></i> <span>Settings</span></a></li>
<li class="treeview">
    <a href="#"><i class="fa fa-plus-circle"></i> <span>Catalog</span> <i class="fa fa-angle-left pull-right"></i></a>
    <ul class="treeview-menu">
        <li><a href='{{ backpack_url('categorie') }}'><i class='fa  fa-reorder'></i> <span>Categories</span></a></li>
        <li><a href='{{ backpack_url('product') }}'><i class='fa  fa-reorder'></i> <span>Products</span></a></li>
        <li><a href='{{ backpack_url('material') }}'><i class='fa fa-reorder'></i> <span>Materials</span></a></li>
    </ul>
</li>
<li class="treeview">
    <a href="#"><i class="fa fa-group"></i> <span>Users, Roles, Permissions</span> <i class="fa fa-angle-left pull-right"></i></a>
    <ul class="treeview-menu">
        <li><a href="{{ backpack_url('user') }}"><i class="fa fa-user"></i> <span>Users</span></a></li>
        <li><a href="{{ backpack_url('role') }}"><i class="fa fa-group"></i> <span>Roles</span></a></li>
        <li><a href="{{ backpack_url('permission') }}"><i class="fa fa-key"></i> <span>Permissions</span></a></li>
    </ul>
</li>
<li><a href="{{ url(config('backpack.base.route_prefix').'/page') }}"><i class="fa fa-file-o"></i> <span>Pages</span></a></li>
