<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

        {{-- <li class="nav-header">Admin Panel</li> --}}
        {{-- <li class="nav-item">
            <a href="{{ route('products.index') }}" class="nav-link">
                <i class="nav-icon fas fa-boxes"></i>
                <p>
                    Products
                </p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('categories.index') }}" class="nav-link">
                <i class="nav-icon fas fa-window-restore"></i>
                <p>
                    Categories
                </p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('subcategories.index') }}" class="nav-link">
                <i class="nav-icon fas fa-cubes"></i>
                <p>
                    Subcategories
                </p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('partners.index') }}" class="nav-link">
                <i class="nav-icon fas fa-handshake"></i>
                <p>
                    Partners
                </p>
            </a>
        </li>

        @can('view', auth()->user())
            <div class="nav-tabs"></div>
            <li class="nav-item">
                <a href="{{ route('users.index') }}" class="nav-link">
                    <i class="nav-icon fas fa-users-cog"></i>
                    <p>
                        Users
                    </p>
                </a>
            </li>
        @endcan

        <div class="nav-tabs"></div>
        @can('view', auth()->user())
            <li class="nav-item">
                <a href="{{ route('inquiries') }}" class="nav-link">
                    <i class="nav-icon fas fa-window-restore"></i>
                    <p>
                        Inquiries
                    </p>
                </a>
            </li>
        @endcan
        <li class="nav-item">
            <a href="{{ route('customers.index') }}" class="nav-link">
                <i class="nav-icon fas fa-child"></i>
                <p>
                    Customers
                </p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('opportunities.index') }}" class="nav-link">
                <i class="nav-icon fas fa-handshake"></i>
                <p>
                    Opportunities
                </p>
            </a>
        </li> --}}

        <div class="nav-tabs"></div>
    </ul>
</nav>
