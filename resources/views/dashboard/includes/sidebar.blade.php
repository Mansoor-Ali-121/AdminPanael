@php
    $segment = request()->segment(3); // will get 'add', 'show', etc.
@endphp

<div class="sidebar">
    <div id="list">
        <div class="quick-shortcut-sidebar container mt-5">

            <div class="list-group">
                <div class="custom-sidebar-menu">

                    <!-- Blogs -->
                    <div class="sidebar-group has-submenu">
                        <span class="sidebar-link {{ in_array($segment, ['add', 'show', 'all-categories', 'add-category']) ? 'active' : '' }}">
                            Blogs <i class="fa-solid fa-arrow-down arrow-icon"></i>
                        </span>
                        <div class="submenu {{ in_array($segment, ['add', 'show', 'all-categories', 'add-category']) ? 'active' : '' }}">

                            <a href="{{ route('blog.show') }}" class="submenu-link {{ $segment == 'show' ? 'active' : '' }}">
                                View Blogs
                            </a>

                            <a href="{{ route('blog.add') }}" class="submenu-link {{ $segment == 'add' ? 'active' : '' }}">
                                Add New Blog
                            </a>

                            <!-- Blog Categories -->
                            <div class="submenu-item has-sub-submenu">
                                <a href="#" class="submenu-link {{ in_array($segment, ['all-categories', 'add-category']) ? 'active' : '' }}">
                                    Blog Categories <i class="fa-solid fa-arrow-down arrow-icon"></i>
                                </a>
                                <div class="sub-submenu {{ in_array($segment, ['all-categories', 'add-category']) ? 'active' : '' }}">
                                    <a href="{{ url('admin/all-categories') }}"
                                       class="submenu-link {{ $segment == 'all-categories' ? 'active' : '' }}">
                                        View Categories
                                    </a>
                                    <a href="{{ url('admin/add-category') }}"
                                       class="submenu-link {{ $segment == 'add-category' ? 'active' : '' }}">
                                        Add New Category
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- SEO Tools -->
                    <div class="sidebar-group has-submenu">
                        <span class="sidebar-link {{ in_array($segment, ['sitemap', 'robots']) ? 'active' : '' }}">
                            SEO Tools <i class="fa-solid fa-arrow-down arrow-icon"></i>
                        </span>
                        <div class="submenu {{ in_array($segment, ['sitemap', 'robots']) ? 'active' : '' }}">
                            <a href="{{ url('admin/sitemap') }}" class="submenu-link {{ $segment == 'sitemap' ? 'active' : '' }}">
                                Sitemap
                            </a>
                            <a href="{{ url('admin/robots') }}" class="submenu-link {{ $segment == 'robots' ? 'active' : '' }}">
                                Robots
                            </a>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Blog Count -->
            <h5 class="mt-4 text-white" id="list-item">
                Total Blogs Posted:
                <span class="text-danger">
                    {{ \App\Models\BlogsModel::count() }}
                </span>
            </h5>

        </div>
    </div>
</div>
