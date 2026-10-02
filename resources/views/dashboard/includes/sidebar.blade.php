@php
    // Ab aapko manually segments define karne ki zaroorat nahi padegi 
    // kyunki hum direct helpers use karenge.
@endphp

<div class="sidebar">
    <div id="list">
        <div class="quick-shortcut-sidebar container mt-5">
            <div class="list-group">
                <div class="custom-sidebar-menu">

                    <a href="{{ route('dashboard') }}"
                        class="sidebar-link {{ Route::is('dashboard') ? 'active' : '' }}">
                        Dashboard
                    </a>

                    <div class="sidebar-group has-submenu">
                        <span class="sidebar-link {{ request()->is('*blogs*') || request()->is('*category*') ? 'active' : '' }}">
                            Blogs <i class="fa-solid fa-arrow-down arrow-icon"></i>
                        </span>

                        <div class="submenu {{ request()->is('*blogs*') || request()->is('*category*') ? 'active' : '' }}">
                            <a href="{{ route('blog.show') }}"
                                class="submenu-link {{ Route::is('blog.show') ? 'active' : '' }}">
                                View Blogs
                            </a>

                            <a href="{{ route('blog.add') }}"
                                class="submenu-link {{ Route::is('blog.add') ? 'active' : '' }}">
                                Add New Blog
                            </a>

                            <div class="submenu-item has-sub-submenu">
                                <a href="#" class="submenu-link {{ request()->is('*category*') ? 'active' : '' }}">
                                    Blog Categories <i class="fa-solid fa-arrow-down arrow-icon"></i>
                                </a>
                                <div class="sub-submenu {{ request()->is('*category*') ? 'active' : '' }}">
                                    <a href="{{ route('category.show') }}"
                                        class="submenu-link {{ Route::is('category.show') ? 'active' : '' }}">
                                        View Categories
                                    </a>
                                    <a href="{{ route('category.add') }}"
                                        class="submenu-link {{ Route::is('category.add') ? 'active' : '' }}">
                                        Add New Category
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="sidebar-group has-submenu">
                        <span class="sidebar-link {{ request()->is('*user*') ? 'active' : '' }}">
                            Admin Panel Users <i class="fa-solid fa-arrow-down arrow-icon"></i>
                        </span>
                        <div class="submenu {{ request()->is('*user*') ? 'active' : '' }}">
                            <a href="{{ route('user.show') }}"
                                class="submenu-link {{ Route::is('user.show') ? 'active' : '' }}">
                                View Users
                            </a>
                            <a href="{{ route('user.add') }}"
                                class="submenu-link {{ Route::is('user.add') ? 'active' : '' }}">
                                Add New User
                            </a>
                        </div>
                    </div>

                    <div class="sidebar-group has-submenu">
                        <span class="sidebar-link {{ request()->is('*service*') ? 'active' : '' }}">
                            Services <i class="fa-solid fa-arrow-down arrow-icon"></i>
                        </span>
                        <div class="submenu {{ request()->is('*service*') ? 'active' : '' }}">
                            <a href="{{ route('service.show') }}"
                                class="submenu-link {{ Route::is('service.show') ? 'active' : '' }}">
                                View Services
                            </a>
                            <a href="{{ route('service.add') }}"
                                class="submenu-link {{ Route::is('service.add') ? 'active' : '' }}">
                                Add New Service
                            </a>
                        </div>
                    </div>

                    <div class="sidebar-group has-submenu">
                        <span class="sidebar-link {{ request()->is('*sitemap*') || request()->is('*robots*') ? 'active' : '' }}">
                            SEO Tools <i class="fa-solid fa-arrow-down arrow-icon"></i>
                        </span>

                        <div class="submenu {{ request()->is('*sitemap*') || request()->is('*robots*') ? 'active' : '' }}">
                            <a href="{{ route('sitemap.show') }}"
                                class="submenu-link {{ request()->is('*sitemap*') ? 'active' : '' }}">
                                Sitemap
                            </a>
                            <a href="{{ route('robots.show') }}"
                                class="submenu-link {{ request()->is('*robots*') ? 'active' : '' }}">
                                Robots
                            </a>
                        </div>
                    </div>

                </div>
            </div>

            <h5 class="mt-4 text-white" id="list-item">
                Total Blogs Posted:
                <span class="text-danger">
                    {{ \App\Models\BlogsModel::count() }}
                </span>
            </h5>
        </div>
    </div>
</div>