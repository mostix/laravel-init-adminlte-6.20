@extends('layouts.admin')

@section('title')
    {{__('custom.home')}}
@endsection

@section('content')
    <div class="row justify-content-center">
    	@if (currentGuard() == "customer")
        <h4 class="text-center">Електронно подаване на информация</h4>
        @foreach(Spatie\Permission\Models\Permission::all()->pluck('name') as $permission)
            @if (currentUser()->can($permission))
            <li style="text-decoration:none; list-style-type: none; margin-left:20px;" @if(strstr(url()->current(), 'notifications')) class="active" @endif>
                @if($permission == 'notifications')
                <a href="{{ route("customers.$permission") }}" style="white-space: normal;">
                    <i class="fa fa-newspaper-o"></i> <span>{{ __("custom.permissions.$permission") }}</span>
                </a>
                @else
                <a style="white-space: normal; color:gray">
                    <i class="fa fa-newspaper-o"></i> <span>{{ __("custom.permissions.$permission") }}</span>
                </a>
                @endif
                
            </li>
            @endif
        @endforeach
   		@endif

    </div>
@endsection
