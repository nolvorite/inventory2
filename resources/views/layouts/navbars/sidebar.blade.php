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
                <a data-toggle="collapse" href="#employees" aria-expanded=true>
                    <i class="tim-icons icon-app"></i>
                    <span class="nav-link-text">Employees</span>
                    <b class="caret mt-1"></b>
                </a>

                <div class="collapse show" id="employees">
                    <ul class="nav pl-4">
                        
                        <li @if (request()->routeIs('employees.index')) class="active " @endif>
                            <a href="{{ route('employees.index') }}">
                                <i class="tim-icons icon-notes"></i>
                                <p>Employees</p>
                            </a>
                        </li>
                        <li @if (request()->routeIs('employees.assign')) class="active " @endif>
                            <a href="{{ route('employees.assign') }}">
                                <i class="tim-icons icon-notes"></i>
                                <p>Assign To Product</p>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

        </ul>
    </div>
</div>
