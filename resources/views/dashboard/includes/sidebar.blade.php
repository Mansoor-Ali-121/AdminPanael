{{-- @if ($this->session->userdata('admin')) { ?> --}}
<div class="sidebar">
    <div id="list">
        <div class="quick-shortcut-sidebar container mt-5">

            <div class="list-group">
                <div class="custom-sidebar-menu">


                    <!-- Blogs -->
                    <div class="sidebar-group has-submenu">
                        <span
                            class="sidebar-link">
                            Blogs <i class="fa-solid fa-arrow-down arrow-icon"></i>
                        </span>
                        <div class="submenu">

                            <div class="submenu-item">
                                <a href="temp"
                                    class="submenu-link">View Blogs</a>

                            </div>

                            <a href=""
                                class="submenu-link">Add New Blog</a>

                            <div class="submenu-item has-sub-submenu">
                                <a href="#"
                                    class="submenu-link">
                                    Blog Categories <i class="fa-solid fa-arrow-down arrow-icon"></i>
                                </a>
                                <div
                                    class="sub-submenu">
                                    <a href=""
                                        class="submenu-link">View
                                        Categories</a>
                                    <a href=""
                                        class="submenu-link">Add
                                        New Category</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Users -->
                    {{-- <div class="sidebar-group has-submenu">
                        <span class="sidebar-link {{in_array($segment, ['users', 'add_user']) ? 'active' : ''}}">
                            Admin Panel Users <i class="fa-solid fa-arrow-down arrow-icon"></i>
                        </span>
                        <div class="submenu {{in_array($segment, ['users', 'add_user']) ? 'active' : ''}}">
                            <a href="{{url('admin/users')}}"
                                class="submenu-link {{$segment == 'users' ? 'active' : ''}}">View Users</a>
                            <a href="{{url('admin/add_user')}}"
                                class="submenu-link {{$segment == 'add_user' ? 'active' : ''}}">Add New
                                User</a>
                        </div>
                    </div> --}}

                    <!-- SEO Tools -->
                    <div class="sidebar-group has-submenu">
                        <span
                            class="sidebar-link">
                            SEO Tools <i class="fa-solid fa-arrow-down arrow-icon"></i>
                        </span>
                        <div
                            class="submenu">
                            <a href=""
                                class="submenu-link">Sitemap</a>
                            <a href=""
                                class="submenu-link">Robots</a>
                        </div>
                    </div>


                </div>
            </div>

            <!-- Blog Count -->
            @php
                // $sql = $this->db->query('SELECT COUNT(*) as count FROM blogs')->row()->count;
                // echo '<h5 class="mt-4 text-white" id="list-item">Total Blogs Posted <span class="text-danger">' . $sql . '</span></h5>';
            @endphp
        </div>
    </div>
</div>

{{-- @endif --}}
