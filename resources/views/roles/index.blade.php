@extends('layouts.admin')

@php
    $singular = trans_choice('custom.roles', 1);
    $plural = trans_choice('custom.roles', 2);
@endphp

@section('title')
    {{ $plural }}
@endsection

@section('header')
    <ol class="breadcrumb">
        <li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i> {{__('custom.home')}}</a></li>
        <li class="active">{{ $plural }}</li>
    </ol>
@endsection

@section('content')<!-- Default box -->
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">{{__('custom.list_with')}} {{ $plural }}</h3>
        <div class="box-tools pull-right">
            @if (Auth::user()->hasRole('admin'))
                <a href="{{ route('roles.create') }}" class="btn btn-sm btn-success">
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
                <th>{{__('validation.attributes.name')}}</th>
                <th>{{__('validation.attributes.created_at')}}</th>
                <th>{{__('validation.attributes.updated_at')}}</th>
                <th>{{__('custom.actions')}}</th>
            </tr>
            </thead>
            <tbody>
            @if(isset($roles) && count($roles))
                @foreach($roles as $role)
                    <tr>
                        <td>{{$role->id}}</td>
                        <td>{{$role->name}}</td>
                        <td>{{ $role->created_at }}</td>
                        <td>{{ $role->updated_at }}</td>
                        <td>
                            <a href="{{route('roles.edit',$role->id)}}"
                               class="btn btn-sm btn-warning"
                               data-toggle="tooltip"
                               title="{{__('custom.edit')}}">
                                <i class="fa fa-edit"></i>
                            </a>
                            <a href="javascript:;"
                               class="btn btn-sm btn-danger js-toggle-delete-resource-modal hidden"
                               data-target="#modal-delete-resource"
                               data-resource-id="{{ $role->id }}"
                               data-resource-name="{{ $role->title }}"
                               data-resource-delete-url="{{route('roles.delete',$role->id)}}"
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
        @if(isset($roles) && count($roles))
            {{ $roles->links() }}
        @endif
    </div>

    @includeIf('modals.delete-resource', ['resource' => $singular])
</div>

@endsection


