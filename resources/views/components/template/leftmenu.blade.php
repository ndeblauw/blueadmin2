<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">

    <!-- Brand Logo -->
    <a href="{{ config('app.url') }}" class="brand-link">
        <span class="brand-text font-weight-light">{{ config('blueadmin.name', Str::limit( config('app.name'), 20) ) }}</span>
        <img src="{{ asset('lteadmin/images/bluepundit_logo.png')}}"
             alt="AdminLTE Logo"
             class="brand-image img-circle elevation-3"
             style="opacity: .8">
    </a>

    <!-- Sidebar -->
    <div class="sidebar">

        <!-- Sidebar user (optional) -->
        @if($user)
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('lteadmin/images/dummy_profilepic.png') }}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{$user->name}}</a>
            </div>
        </div>
        @endif

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                @foreach($menu as $item)
                    {{-- MENU HEADER //////////////////////////////////////////////////////////////////////--}}
                    @if(array_key_exists('type', $item))
                        <li class="nav-header">{{ strtoupper($item['title']) }}</li>
                        @continue
                    @endif

                    {{-- SIMPLE MENU ITEM //////////////////////////////////////////////////////////////// --}}
                    @if( !array_key_exists('submenu', $item) )
                        <li class="nav-item">
                            <a href="{{$item['link'] ?? '#' }}" class="nav-link @if( array_key_exists('active', $item)) active @endif">
                                <i class="nav-icon {{$item['icon'] ?? 'far fa-circle' }}"></i>
                                <p>
                                    {{$item['title'] ?? 'title missing' }}
                                    @if(array_key_exists('badge', $item))
                                        <span class="right badge badge-{{$item['badgeColor'] ?? 'primary'}}">{{$item['badge']}}</span>
                                    @endif
                                </p>
                            </a>
                        </li>
                        @continue
                    @endif

                    {{-- MENU ITEM WITH SUBMENU ////////////////////////////////////////////////////////// --}}
                    @if( array_key_exists('submenu', $item))
                        <li class="nav-item has-treeview @if( array_key_exists('active', $item)) menu-open @endif">
                            <a href="#" class="nav-link @if( array_key_exists('active', $item)) active @endif">
                                <i class="nav-icon {{$item['icon']}}"></i>
                                <p>
                                    {{$item['title']}}
                                    <i class="right fas fa-angle-left"></i>
                                    @if(array_key_exists('badge', $item))
                                        <span class="right badge badge-{{$item['badgeColor'] ?? 'primary'}}">{{$item['badge']}}</span>
                                    @endif
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                @foreach($item['submenu'] as $subitem)
                                    <li class="nav-item">
                                        <a href="{{$subitem['link'] ?? '#'}}" class="nav-link @if( array_key_exists('active', $subitem)) active @endif">
                                            <i class="nav-icon {{$subitem['icon'] ?? 'far fa-circle' }}"></i>
                                            <p>{{$subitem['title'] ?? 'title missing' }}</p>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                    @endif

                @endforeach

            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
