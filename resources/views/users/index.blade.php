@extends('layouts.admin')

@php
    $singular = trans_choice('custom.users', 1);
    $plural = trans_choice('custom.users', 2);
@endphp

@section('title')
    {{ $plural }}
@endsection

@section('header')
    <div class="btn-group pull-right">
        <a class="btn btn-sm {{$active == 1 ? 'btn-success' : 'btn-default'}}" href="?active=1">
            <i class="fa fa-check-circle"></i> {{ trans_choice('custom.inactive_f', 1) }}
        </a>

        <a class="btn btn-sm {{$active == 0 ? 'btn-danger' : 'btn-default'}}" href="?active=0">
            <i class="fa fa-times-circle"></i> {{ trans_choice('custom.inactive_f', 2) }}
        </a>
    </div>
    <ol class="breadcrumb">
        <li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i> {{__('custom.home')}}</a></li>
        <li class="active">{{ $plural }}</li>
    </ol>
@endsection

@section('content')<!-- Default box -->
<div class="box box-success">
    <div class="box-header with-border">
        <h3 class="box-title">{{ __('custom.search') }}</h3>

        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                    title="Collapse">
                <i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                <i class="fa fa-times"></i></button>
        </div>
    </div>
    <div class="box-body">
        <div class="row">
            <form method="GET">

                <div class="col-xs-12 col-md-2">
                    <input type="text" name="username" placeholder="{{__('validation.attributes.username')}}" class="form-control"
                           value="{{request()->get('username')}}">
                </div>

                <div class="col-xs-12 col-md-2">
                    <input type="text" name="email" placeholder="{{__('validation.attributes.email')}}" class="form-control"
                           value="{{request()->get('email')}}">
                </div>
                <div class="col-xs-12 col-md-2">
                    <button type="submit" class="btn btn-success btn-sm btn-block"><i class="fa fa-search"></i> {{__('custom.search')}}
                    </button>
                </div>
                <div class="col-xs-12 col-md-2">
                    <a href="{{route('users')}}" class="btn btn-sm btn-default"> {{__('custom.clear')}}</a>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">{{__('custom.list_with')}} {{ $plural }}</h3>
        <div class="box-tools pull-right">
            @if (Auth::user()->hasRole('admin'))
                <a href="{{ route('users.create') }}" class="btn btn-sm btn-success">
                   {{__('custom.add')}} {{$singular}}
                </a>
            @endif
        </div>
    </div>
    <div class="box-body">
        <table class="table table-bordered" width="100%" cellspacing="0">
            <thead>
            <tr>
                <th>ID</th>
                <th>{{__('validation.attributes.username')}}</th>
                <th>{{__('validation.attributes.first_name')}}</th>
                <th>{{__('validation.attributes.email')}}</th>
                <th>{{__('validation.attributes.role')}}</th>
                <th>{{__('custom.active_m')}}</th>
                <th>{{__('validation.attributes.created_at')}}</th>
                <th>{{__('validation.attributes.updated_at')}}</th>
                <th>{{__('custom.actions')}}</th>
            </tr>
            </thead>
            <tbody>
            @if(isset($users) && count($users))
                @foreach($users as $user)
                    <tr>
                        <td>{{$user->id}}</td>
                        <td>{{$user->username}}</td>
                        <td>{{$user->first_name}} {{$user->last_name}}</td>
                        <td>{{$user->email}}</td>
                        <td>{{ implode(', ',$user->getRoleNames()->toArray()) }}</td>
                        <td>
                            <div id="active_form{{$user->id}}">
                                <input type="hidden" name="id" class="id" value="{{$user->id}}">
                                <input type="hidden" name="model" class="model" value="User">
                                <div class="status-box">
                                    @if ($user->active)
                                        <span class="label bg-green status" style="cursor: pointer" data-status="0" onclick="ToggleBoolean('active','{{$user->id}}')">
                                            {{__('custom.yes')}}
                                        </span>
                                    @else
                                        <span class="label bg-red status" style="cursor: pointer" data-status="1" onclick="ToggleBoolean('active','{{$user->id}}')">
                                            {{__('custom.no')}}
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td>{{ $user->created_at }}</td>
                        <td>{{ $user->updated_at }}</td>
                        <td>
                            <a href="{{route('users.edit',$user->id)}}"
                               class="btn btn-sm btn-warning"
                               data-toggle="tooltip"
                               title="{{__('custom.edit')}}">
                                <i class="fa fa-edit"></i>
                            </a>
                            <a href="javascript:;"
                               class="btn btn-sm btn-danger js-toggle-delete-resource-modal"
                               data-target="#modal-delete-resource"
                               data-resource-id="{{ $user->id }}"
                               data-resource-name="{{ $user->username }}"
                               data-resource-delete-url="{{route('users.delete',$user->id)}}"
                               data-toggle="tooltip"
                               title="{{__('custom.delete')}}">
                                <i class="fa fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            @endif
            </tbody>
        </table>
        @if(isset($users) && count($users))
            {{ $users->links() }}
        @endif
    </div>

    @includeIf('modals.delete-resource', ['resource' => $singular])
</div>

@endsection


