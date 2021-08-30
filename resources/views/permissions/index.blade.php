@extends('layouts.admin')

@php
    $singular = trans_choice('custom.users', 1);
    $plural = trans_choice('custom.users', 2);
@endphp

@section('title')
    {{ $plural }}
@endsection

@section('header')
    <ol class="breadcrumb">
        <li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i> {{__('custom.home')}}</a></li>
        <li class="active">Права на потребители</li>
    </ol>
@endsection

@section('content')<!-- Default box -->
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">{{__('custom.list_with')}} {{ $plural }}</h3>

    </div>
    <div class="box-body">
        <table class="table table-bordered" width="100%" cellspacing="0">
            <thead>
            <tr>
                <th>Потребител</th>
                @foreach($permissions as $permission)
                    <th>{{ __("custom.permissions.$permission") }}</th>
                @endforeach
            </tr>
            </thead>
            <tbody>
            @if(isset($users) && count($users))
                @foreach($users as $user)
                <tr>
                    <td>{{ $user->username }}</td>
                    @php
                        $permissionNames = $user->getPermissionNames()->toArray();
                    @endphp
                    @foreach($permissions as $permission)
                    <td>
                        <div id="{{$permission}}_form_{{$user->id}}">
                            <input type="hidden" name="id" class="id" value="{{$user->id}}">
                            <input type="hidden" name="model" class="model" value="User">
                            <div class="status-box">
                                @if (in_array($permission, $permissionNames))
                                    <span class="label bg-green status" style="cursor: pointer" data-status="0" onclick="TogglePermission('{{$permission}}','{{$user->id}}')">
                                    {{__('custom.yes')}}
                                </span>
                                @else
                                    <span class="label bg-red status" style="cursor: pointer" data-status="1" onclick="TogglePermission('{{$permission}}','{{$user->id}}')">
                                    {{__('custom.no')}}
                                </span>
                                @endif
                            </div>
                        </div>
                    </td>
                    @endforeach
                </tr>
                @endforeach
            @endif
            </tbody>
        </table>
    </div>

</div>

@endsection


