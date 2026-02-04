@php
use Illuminate\Support\Facades\Route;
@endphp

<aside id="layout-menu" class="layout-menu menu-vertical menu">

    <!-- App Brand -->
    <div class="app-brand demo">
        <a href="{{ url('/') }}" class="app-brand-link">
            <span class="app-brand-logo">@include('_partials.macros')</span>
        </a>
        <a href="javascript:void(0);" class="layout-menu-toggle menu-link ms-auto"></a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">

        <!-- Dashboard -->
        <li class="menu-item {{ request()->is('dashboard*') ? 'active' : '' }}">
            <a href="{{ url('/') }}" class="menu-link">
                <span class="menu-icon">
                    <!-- Layout Grid -->
                    <svg viewBox="0 0 24 24" width="20" height="20" fill="none"
                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="3" width="7" height="7"/>
                        <rect x="14" y="3" width="7" height="7"/>
                        <rect x="14" y="14" width="7" height="7"/>
                        <rect x="3" y="14" width="7" height="7"/>
                    </svg>
                </span>
                <div>Dashboard</div>
            </a>
        </li>

        <!-- Projects / Meetings -->
        <li class="menu-item {{ request()->is('projects*') ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <span class="menu-icon">
                    <!-- Folder -->
                    <svg viewBox="0 0 24 24" width="20" height="20" fill="none"
                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M3 7h5l2 2h11v10H3z"/>
                    </svg>
                </span>
                <div>Project / Meeting</div>
            </a>
            <ul class="menu-sub">
                <!-- CORRECTED: Using route() helper instead of url() -->
                <li class="{{ request()->routeIs('projects.create') ? 'active' : '' }}">
                    <a href="{{ route('projects.create') }}" class="menu-link">
                        <div>Add Project</div>
                    </a>
                </li>
                <li class="{{ request()->routeIs('projects.index') ? 'active' : '' }}">
                    <a href="{{ route('projects.index') }}" class="menu-link">
                        <div>View Projects</div>
                    </a>
                </li>
            </ul>
        </li>

        {{-- <!-- Tasks -->
        <li class="menu-item {{ request()->is('tasks*') ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <span class="menu-icon">
                    <!-- Checklist -->
                    <svg viewBox="0 0 24 24" width="20" height="20" fill="none"
                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M9 11l3 3L22 4"/>
                        <path d="M2 6h11"/>
                        <path d="M2 12h11"/>
                        <path d="M2 18h11"/>
                    </svg>
                </span>
                <div>Tasks</div>
            </a>
            <ul class="menu-sub">
                <!-- CORRECTED: Using route names (assuming you have task routes) -->
                <li class="{{ request()->routeIs('tasks.index') ? 'active' : '' }}">
                    <a href="{{ route('tasks.index') }}" class="menu-link">
                        <div>All Tasks</div>
                    </a>
                </li>
                <li class="{{ request()->routeIs('tasks.assigned') ? 'active' : '' }}">
                    <a href="{{ route('tasks.assigned') }}" class="menu-link">
                        <div>Assigned to Me</div>
                    </a>
                </li>
            </ul>
        </li> --}}
        <!-- Tasks -->
        <li class="menu-item {{ request()->is('tasks*') ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <span class="menu-icon">
                    <i class="ri-task-line"></i>
                </span>
                <div>Tasks</div>
            </a>
            <ul class="menu-sub">
                <li class="{{ request()->routeIs('tasks.index') ? 'active' : '' }}">
                    <a href="{{ route('tasks.index') }}" class="menu-link">
                        <div>All Tasks</div>
                    </a>
                </li>
                <li class="{{ request()->routeIs('tasks.assigned') ? 'active' : '' }}">
                    <a href="{{ route('tasks.assigned') }}" class="menu-link">
                        <div>Assigned to Me</div>
                    </a>
                </li>
                <li class="{{ request()->routeIs('tasks.create') ? 'active' : '' }}">
                    <a href="{{ route('tasks.create') }}" class="menu-link">
                        <div>Add Task</div>
                    </a>
                </li>
            </ul>
        </li>

        <!-- Users -->
        <li class="menu-item {{ request()->is('users*') ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <span class="menu-icon">
                    <!-- Users -->
                    <svg viewBox="0 0 24 24" width="20" height="20" fill="none"
                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="9" cy="7" r="4"/>
                        <circle cx="17" cy="7" r="3"/>
                        <path d="M3 21c0-4 4-7 6-7"/>
                        <path d="M14 21c0-3 3-5 5-5"/>
                    </svg>
                </span>
                <div>Users Mgmt</div>
            </a>
            <ul class="menu-sub">
                <li class="{{ request()->routeIs('users.create') ? 'active' : '' }}">
                    <a href="{{ route('users.create') }}" class="menu-link">
                        <div>Add User</div>
                    </a>
                </li>
                <li class="{{ request()->routeIs('users.index') ? 'active' : '' }}">
                    <a href="{{ route('users.index') }}" class="menu-link">
                        <div>Users List</div>
                    </a>
                </li>
            </ul>
        </li>

        <!-- Roles & Permissions -->
        <li class="menu-item {{ request()->is('roles*') || request()->is('permissions*') ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <span class="menu-icon">
                    <!-- Shield -->
                    <svg viewBox="0 0 24 24" width="20" height="20" fill="none"
                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 2l8 4v6c0 5-3.5 9-8 10-4.5-1-8-5-8-10V6z"/>
                    </svg>
                </span>
                <div>Roles & Permissions</div>
            </a>

            <ul class="menu-sub">
                <!-- Roles -->
                <li class="{{ request()->routeIs('roles.index') ? 'active' : '' }}">
                    <a href="{{ route('roles.index') }}" class="menu-link">
                        <span class="menu-icon">
                            <!-- User Shield -->
                            <svg viewBox="0 0 24 24" width="18" height="18" fill="none"
                                stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="8" r="3"/>
                                <path d="M6 21c0-3.5 4-6 6-6s6 2.5 6 6"/>
                            </svg>
                        </span>
                        <div>Manage Roles</div>
                    </a>
                </li>

                <!-- Permissions -->
                <li class="{{ request()->routeIs('permissions.index') ? 'active' : '' }}">
                    <a href="{{ route('permissions.index') }}" class="menu-link">
                        <span class="menu-icon">
                            <!-- Key -->
                            <svg viewBox="0 0 24 24" width="18" height="18" fill="none"
                                stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="7" cy="14" r="3"/>
                                <path d="M10 14h10"/>
                                <path d="M17 11v6"/>
                            </svg>
                        </span>
                        <div>Permissions</div>
                    </a>
                </li>
            </ul>
        </li>

    </ul>
</aside>
