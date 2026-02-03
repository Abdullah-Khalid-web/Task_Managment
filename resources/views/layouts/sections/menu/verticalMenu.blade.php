@php
use Illuminate\Support\Facades\Route;
@endphp
<aside id="layout-menu" class="layout-menu menu-vertical menu">

    <!-- ! Hide app brand if navbar-full -->
    <div class="app-brand demo">
        <a href="{{url('/')}}" class="app-brand-link">
            <span class="app-brand-logo">@include('_partials.macros')</span>

        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">

        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <li class="menu-item {{ request()->is('dashboard*') ? 'active' : '' }}">
            <a href="{{ url('/') }}" class="menu-link">
                <div>Dashboard</div>
            </a>
        </li>
        <li class="menu-item {{ request()->is('projects*') ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <div>Project/Meeting</div>
            </a>
            <ul class="menu-sub">
                <li>
                    <a href="#" class="menu-link">
                        <div>View Projects</div>
                    </a>
                </li>
                <li>
                    <a href="#" class="menu-link">
                        <div>Meetings Schedule</div>
                    </a>
                </li>
            </ul>
        </li>

        <li class="menu-item {{ request()->is('tasks*') ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <div>Tasks</div>
            </a>
            <ul class="menu-sub">
                <li>
                    <a href="#" class="menu-link">
                        <div>All Tasks</div>
                    </a>
                </li>
                <li>
                    <a href="#" class="menu-link">
                        <div>Assigned to Me</div>
                    </a>
                </li>
            </ul>
        </li>

        <li class="menu-item {{ request()->is('users*') ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <div>Users</div>
            </a>
            <ul class="menu-sub">
                <li>
                    <a href="#" class="menu-link">
                        <div>User List</div>
                    </a>
                </li>
            </ul>
        </li>

        <li class="menu-item {{ request()->is('roles*') ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <div>Roles</div>
            </a>
            <ul class="menu-sub">
                <li>
                    <a href="#" class="menu-link">
                        <div>Manage Roles</div>
                    </a>
                </li>
                <li>
                    <a href="#" class="menu-link">
                        <div>Permissions</div>
                    </a>
                </li>
            </ul>
        </li>
    </ul>

</aside>