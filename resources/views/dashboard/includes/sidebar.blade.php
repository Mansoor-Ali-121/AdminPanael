@php
    $segment2 = request()->segment(2); // e.g., blogs
    $segment3 = request()->segment(3); // e.g., category, add
    $segment4 = request()->segment(4); // e.g., show, edit
@endphp

<div class="sidebar">
    <div id="list">
        <div class="quick-shortcut-sidebar container mt-5">
            <div class="list-group">
                <div class="custom-sidebar-menu">

                    <!-- Blogs -->
                    <div class="sidebar-group has-submenu">
                        <span class="sidebar-link {{ $segment2 === 'blogs' ? 'active' : '' }}">
                            Blogs <i class="fa-solid fa-arrow-down arrow-icon"></i>
                        </span>

                        <div class="submenu {{ $segment2 === 'blogs' ? 'active' : '' }}">
                            <a href="{{ route('blog.show') }}"
                                class="submenu-link {{ $segment3 === 'show' && $segment2 === 'blogs' ? 'active' : '' }}">
                                View Blogs
                            </a>

                            <a href="{{ route('blog.add') }}"
                                class="submenu-link {{ $segment3 === 'add' && $segment2 === 'blogs' ? 'active' : '' }}">
                                Add New Blog
                            </a>

                            <!-- Blog Categories -->
                            <div class="submenu-item has-sub-submenu">
                                <a href="#" class="submenu-link {{ $segment3 === 'category' ? 'active' : '' }}">
                                    Blog Categories <i class="fa-solid fa-arrow-down arrow-icon"></i>
                                </a>
                                <div class="sub-submenu {{ $segment3 === 'category' ? 'active' : '' }}">
                                    <a href="{{ route('category.show') }}"
                                        class="submenu-link {{ $segment4 === 'show' && $segment3 === 'category' ? 'active' : '' }}">
                                        View Categories
                                    </a>
                                    <a href="{{ route('category.add') }}"
                                        class="submenu-link {{ $segment4 === 'add' && $segment3 === 'category' ? 'active' : '' }}">
                                        Add New Category
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Admin Panel Users -->
                    <div class="sidebar-group has-submenu">
                        <span
                            class="sidebar-link {{ in_array($segment2, ['users_show', 'users_add']) ? 'active' : '' }}">
                            Admin Panel Users <i class="fa-solid fa-arrow-down arrow-icon"></i>
                        </span>
                        <div class="submenu {{ in_array($segment2, ['users_show', 'users_add']) ? 'active' : '' }}">
                            <a href="{{ route('user.show') }}"
                                class="submenu-link {{ $segment2 === 'users_show' ? 'active' : '' }}">
                                View Users
                            </a>
                            <a href="{{ route('user.add') }}"
                                class="submenu-link {{ $segment2 === 'users_add' ? 'active' : '' }}">
                                Add New User
                            </a>
                        </div>
                    </div>

                    <!-- SEO Tools -->
                    <div class="sidebar-group has-submenu">
                        <span
                            class="sidebar-link {{ in_array($segment2, ['sitemap', 'robots', 'add_robots', 'add_url', 'edit_url']) ? 'active' : '' }}">
                            SEO Tools <i class="fa-solid fa-arrow-down arrow-icon"></i>
                        </span>

                        <div
                            class="submenu {{ in_array($segment2, ['sitemap', 'robots', 'add_robots', 'add_url', 'edit_url']) ? 'active' : '' }}">
                            <a href="{{ route('sitemap.show') }}"
                                class="submenu-link {{ in_array($segment2, ['sitemap', 'add_url', 'edit_url']) ? 'active' : '' }}">
                                Sitemap
                            </a>
                            <a href="{{ route('robots.show') }}"
                                class="submenu-link {{ in_array($segment2, ['robots', 'add_robots']) ? 'active' : '' }}">
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
