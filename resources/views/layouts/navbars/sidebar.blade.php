<div class="sidebar">
    <div class="sidebar-wrapper">
        <ul class="nav">
            <li @if ($pageSlug == 'dashboard') class="active " @endif>
                <a href="{{ route('home') }}">
                    <i class="tim-icons icon-chart-bar-32"></i>
                    <p>Dashboard</p>
                </a>
            </li>



            <li>
                <a data-toggle="collapse" href="#inventory" aria-expanded=true>
                    <i class="tim-icons icon-app"></i>
                    <span class="nav-link-text">Inventory</span>
                    <b class="caret mt-1"></b>
                </a>

                <div class="collapse show" id="inventory">
                    <ul class="nav pl-4">
                        
                        <li @if (request()->routeIs('products.index')) class="active " @endif>
                            <a href="{{ route('products.index') }}">
                                <i class="tim-icons icon-notes"></i>
                                <p>Products</p>
                            </a>
                        </li>
                        <li @if (request()->routeIs('products.create')) class="active " @endif>
                            <a href="{{ route('products.create') }}">
                                <i class="tim-icons icon-notes"></i>
                                <p>Add New Product</p>
                            </a>
                        </li>
                        <li @if ($pageSlug == 'categories') class="active " @endif>
                            <a href="{{ route('categories.index') }}">
                                <i class="tim-icons icon-tag"></i>
                                <p>Product Types</p>
                            </a>
                        </li>

                        <!-- <li @if ($pageSlug == 'receipts') class="active " @endif>
                            <a href="{{ route('receipts.index') }}">
                                <i class="tim-icons icon-paper"></i>
                                <p>Receipts</p>
                            </a>
                        </li> -->
                        <!-- <li @if ($pageSlug == 'istats') class="active " @endif>
                            <a href="{{ route('inventory.stats') }}">
                                <i class="tim-icons icon-chart-pie-36"></i>
                                <p>Statistics</p>
                            </a>
                        </li> -->
                    </ul>
                </div>
            </li>

            <li>
                <a data-toggle="collapse" href="#assignments" aria-expanded=true>
                    <i class="tim-icons icon-check-2"></i>
                    <span class="nav-link-text">Assignments</span>
                    <b class="caret mt-1"></b>
                </a>

                <div class="collapse show" id="assignments">
                    <ul class="nav pl-4">
                        
                        <li @if (request()->routeIs('products.index')) class="active " @endif>
                            <a href="{{ route('products.index') }}">
                                <i class="tim-icons icon-check-2"></i>
                                <p>Assignments</p>
                            </a>
                        </li>

                    </ul>
                </div>
            </li>

            <li>
                <a data-toggle="collapse" href="#employees" aria-expanded=true>
                    <i class="tim-icons icon-single-02"></i>
                    <span class="nav-link-text">Users</span>
                    <b class="caret mt-1"></b>
                </a>

                <div class="collapse show" id="employees">
                    <ul class="nav pl-4">
                        
                        <!-- <li @if (request()->routeIs('admin.user_management.user.index')) class="active " @endif>
                            <a href="{{ route('admin.user_management.user.index') }}">
                                <i class="tim-icons icon-single-02"></i>
                                <p>List Of Users</p>
                            </a>
                        </li> -->
                        <li @if (request()->routeIs('admin.user_management.user.index_e')) class="active " @endif>
                            <a href="{{ route('admin.user_management.user.index_e') }}">
                                <i class="tim-icons icon-single-02"></i>
                                <p>List Of Employees</p>
                            </a>
                        </li>
                        <li @if (request()->routeIs('admin.user_management.user.index_c')) class="active " @endif>
                            <a href="{{ route('admin.user_management.user.index_c') }}">
                                <i class="tim-icons icon-single-02"></i>
                                <p>List Of Customers</p>
                            </a>
                        </li>
                        
                        <li @if (request()->routeIs('admin.user_management.user.create.customer')) class="active " @endif>
                            <a href="{{ route('admin.user_management.user.create.customer') }}">
                                <i class="tim-icons icon-single-02"></i>
                                <p>Add New Customer</p>
                            </a>
                        </li>
                        <li @if (request()->routeIs('admin.user_management.user.create.employee')) class="active " @endif>
                            <a href="{{ route('admin.user_management.user.create.employee') }}">
                                <i class="tim-icons icon-single-02"></i>
                                <p>Add New Employee</p>
                            </a>
                        </li>            
                        <li @if (request()->routeIs('admin.user_management.department.index')) class="active " @endif>
                            <a href="{{ route('admin.user_management.department.index') }}">
                                <i class="tim-icons icon-single-02"></i>
                                <p>User Types</p>
                            </a>
                        </li><!--
                        <li @if (request()->routeIs('admin.user_management.role.*')) class="active " @endif>
                            <a href="{{ route('admin.user_management.role.index') }}">
                                <i class="tim-icons icon-single-02"></i>
                                <p>Roles</p>
                            </a>
                        </li> -->
                    </ul>
                </div>
            </li>

        </ul>
    </div>
</div>
