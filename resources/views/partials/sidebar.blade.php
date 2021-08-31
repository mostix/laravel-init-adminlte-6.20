<aside class="main-sidebar">
    <section class="sidebar">
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">Табло</li>
            <li @if(strstr(url()->current(), 'home')) class="active" @endif>
                <a href="{{ route('home') }}">
                    <i class="fa fa-dashboard"></i> <span>{{ __('custom.home') }}</span>
                </a>
            </li>
            @if (Auth::guard(currentGuard())->user()->hasRole('admin'))
                <li class="header">{{ trans_choice('custom.activity_logs', 1) }}</li>
                <li @if(strstr(url()->current(), 'activity-logs')) class="active" @endif>
                    <a href="{{route('admin.activity-logs')}}">
                        <i class="fa fa-clock-o"></i> <span>{{ trans_choice('custom.activity_logs', 2) }}</span>
                    </a>
                </li>
            @endif
            @if (Auth::guard(currentGuard())->user()->hasRole('admin'))
                <li class="header">Система и потребители</li>
                <li @if(strstr(url()->current(), 'roles')) class="active" @endif>
                    <a href="{{route('admin.roles')}}">
                        <i class="fa fa-users"></i> <span>{{ trans_choice('custom.roles', 2) }}</span>
                    </a>
                </li>
                <li @if(strstr(url()->current(), 'users')) class="active" @endif>
                    <a href="{{route('admin.users')}}">
                        <i class="fa fa-user"></i> <span>{{ trans_choice('custom.users', 2) }}</span>
                    </a>
                </li>
{{--                <li @if(strstr(url()->current(), 'permissions')) class="active" @endif>--}}
{{--                    <a href="{{route('permissions')}}">--}}
{{--                        <i class="fa fa-legal"></i> <span>{{ trans_choice('custom.permissions', 2) }} на потребители</span>--}}
{{--                    </a>--}}
{{--                </li>--}}
            @endif
        </ul>
    </section>
</aside>
