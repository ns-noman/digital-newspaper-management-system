@inject('authorization', 'App\Services\AuthorizationService')
<aside class="main-sidebar sidebar-dark-primary elevation-0 bg-info">
    <a href="{{ route('profile.update-details') }}" class="brand-link">
        <img src="{{ $userImage }}" alt="{{ $basicInfo->title }} Logo" class="brand-image img-circle elevation-3"
            style="opacity: .8" height="30" width="30">
        <span class="brand-text font-weight-dark text-dark">{{ Auth::guard('admin')->user()->name }}</span>
    </a>
    <div class="sidebar" style="background-color: #083344">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                @if ($authorization->hasMenuAccess(1))
                    <li class="nav-item {{ request()->is('admin/dashboard') ? 'menu-open' : '' }}">
                        <a href="{{ url('admin/dashboard') }}"
                            class="nav-link {{ request()->is('admin/dashboard') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>
                                Dashboard
                            </p>
                        </a>
                    </li>
                @endif
                @if ($authorization->hasMenuAccess(2))
                    <li class="nav-item">
                        <a href="{{ route('news.index') }}"
                            class="nav-link {{ request()->is('admin/news*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-edit"></i>
                            <p>News <i class="fas right fa-solid fa-plus add-new p-1" add-new="{{ route('news.create') }}"></i></p>
                        </a>
                    </li>
                @endif
                @if ($authorization->hasMenuAccess(3))
                    <li class="nav-item {{ request()->is('admin/basic-infos*') ? 'menu-open' : '' }}">
                        <a href="{{ url('admin/basic-infos') }}"
                            class="nav-link {{ request()->is('admin/basic-infos*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-edit"></i>
                            <p>Basic Info Manage</p>
                        </a>
                    </li>
                @endif
                @if ($authorization->hasMenuAccess(4))
                    <li class="nav-item {{ request()->is('admin/admin*') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->is('admin/admin*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-edit"></i>
                            <p>
                                Admin
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @if ($authorization->hasMenuAccess(38))
                                <li class="nav-item">
                                    <a href="{{ route('roles.index') }}"
                                        class="nav-link {{ request()->is('admin/admin/roles*') ? 'active' : '' }}">
                                        <i class="far fa-dot-circle nav-icon"></i>
                                        <p>Roles <i class="fas right fa-solid fa-plus add-new p-1" add-new="{{ route('roles.create') }}"></i></p>
                                    </a>
                                </li>
                            @endif
                            @if ($authorization->hasMenuAccess(42))
                                <li class="nav-item">
                                    <a href="{{ route('admins.index') }}"
                                        class="nav-link {{ request()->is('admin/admin/admins*') ? 'active' : '' }}">
                                        <i class="far fa-dot-circle nav-icon"></i>
                                        <p>Admins <i class="fas right fa-solid fa-plus add-new p-1" add-new="{{ route('admins.create') }}"></i></p>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif
                @if ($authorization->hasMenuAccess(5))
                <li class="nav-item">
                        <a href="{{ route('categories.index') }}"
                            class="nav-link {{ request()->is('admin/categories*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-edit"></i>
                            <p>Category <i class="fas right fa-solid fa-plus add-new p-1" add-new="{{ route('categories.create') }}"></i></p>
                        </a>
                        
                    </li>
                @endif
                @if ($authorization->hasMenuAccess(6))
                    <li class="nav-item">
                        <a href="{{ route('tags.index') }}"
                            class="nav-link {{ request()->is('admin/tags*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-edit"></i>
                            <p>Tags <i class="fas right fa-solid fa-plus add-new p-1" add-new="{{ route('tags.create') }}"></i></p>
                        </a>
                    </li>
                @endif
                @if ($authorization->hasMenuAccess(7))
                    <li class="nav-item">
                        <a href="{{ route('writers.index') }}"
                            class="nav-link {{ request()->is('admin/writers*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-edit"></i>
                            <p>Writers <i class="fas right fa-solid fa-plus add-new p-1" add-new="{{ route('writers.create') }}"></i></p>
                        </a>
                    </li>
                @endif
                @if ($authorization->hasMenuAccess(8))
                    <li class="nav-item">
                        <a href="{{ route('reporters.index') }}"
                            class="nav-link {{ request()->is('admin/reporters*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-edit"></i>
                            <p>Reporters <i class="fas right fa-solid fa-plus add-new p-1" add-new="{{ route('reporters.create') }}"></i></p>
                        </a>
                    </li>
                @endif
                @if ($authorization->hasMenuAccess(9))
                    <li class="nav-item">
                        <a href="{{ route('pages.index') }}"
                            class="nav-link {{ request()->is('admin/pages*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-edit"></i>
                            <p>Pages <i class="fas right fa-solid fa-plus add-new p-1" add-new="{{ route('pages.create') }}"></i></p>
                        </a>
                    </li>
                @endif
                @if ($authorization->hasMenuAccess(10))
                    <li class="nav-item">
                        <a href="{{ route('polls.index') }}"
                            class="nav-link {{ request()->is('admin/polls*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-edit"></i>
                            <p>Polls <i class="fas right fa-solid fa-plus add-new p-1" add-new="{{ route('polls.create') }}"></i></p>
                        </a>
                    </li>
                @endif
                @if ($authorization->hasMenuAccess(11))
                    <li class="nav-item">
                        <a href="{{ route('galleries.index') }}"
                            class="nav-link {{ request()->is('admin/galleries*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-edit"></i>
                            <p>Gallery <i class="fas right fa-solid fa-plus add-new p-1" add-new="{{ route('galleries.create') }}"></i></p>
                        </a>
                    </li>
                @endif
                @if ($authorization->hasMenuAccess(12))
                    <li class="nav-item">
                        <a href="{{ route('ads-positions.index') }}"
                            class="nav-link {{ request()->is('admin/ads-positions*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-edit"></i>
                            <p>Ads Positions <i class="fas right fa-solid fa-plus add-new p-1" add-new="{{ route('ads-positions.create') }}"></i></p>
                        </a>
                    </li>
                @endif
                @if ($authorization->hasMenuAccess(13))
                    <li class="nav-item">
                        <a href="{{ route('my-ads.index') }}"
                            class="nav-link {{ request()->is('admin/my-ads*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-edit"></i>
                            <p>Ads <i class="fas right fa-solid fa-plus add-new p-1" add-new="{{ route('my-ads.create') }}"></i></p>
                        </a>
                    </li>
                @endif
            </ul>
        </nav>
    </div>
</aside>
<aside class="control-sidebar control-sidebar-dark"></aside>
