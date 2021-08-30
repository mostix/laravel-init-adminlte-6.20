@extends('layouts.admin')

@php
    $singular = trans_choice('custom.users', 1);
    $plural = trans_choice('custom.users', 2);
@endphp

@section('title')
    {{__('custom.add')}} {{ $singular }}
@endsection

@section('header')
    <ol class="breadcrumb">
        <li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i> {{__('custom.home')}}</a></li>
        <li><a href="{{route('users')}}"><i class="fa fa-user"></i> {{ $plural }}</a></li>
        <li class="active">{{__('custom.add')}} {{ $singular }}</li>
    </ol>
@endsection

@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title my-2">{{__('custom.add')}} {{ $singular }}</h3>

            <form action="{{ route('users.store') }}" method="post" role="form" id="form"
                  class="form-horizontal form-groups-bordered">
                @csrf

                <div class="form-group">
                    <label class="col-sm-3 control-label" for="username">{{ __('validation.attributes.username') }}<span class="required">*</span></label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" id="username" name="username" class="form-control" value="{{ old('username') }}">
                        @error('username')
                        <div class="alert alert-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label" for="first_name">{{ __('validation.attributes.first_name') }}<span class="required">*</span></label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" id="first_name" name="first_name" class="form-control" value="{{ old('first_name') }}">
                        @error('first_name')
                        <div class="alert alert-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label" for="middle_name">{{ __('validation.attributes.middle_name') }}</label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" id="middle_name" name="middle_name" class="form-control" value="{{ old('middle_name') }}">
                        @error('middle_name')
                        <div class="alert alert-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label" for="last_name">{{ __('validation.attributes.last_name') }}<span class="required">*</span></label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" id="last_name" name="last_name" class="form-control" value="{{ old('last_name') }}">
                        @error('last_name')
                        <div class="alert alert-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>


                <div class="form-group">
                    <label class="col-sm-3 control-label" for="email">{{ __('validation.attributes.email') }}<span class="required">*</span></label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}">
                        @error('email')
                        <div class="alert alert-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label" for="password_confirmation">{{ __('validation.attributes.role') }}<span class="required">*</span></label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <select name="role[]" id="role" multiple class="form-control">
                            @foreach($roles as $role)
                                <option value="{{$role->id}}">{{$role->name}}</option>
                            @endforeach
                        </select>
                        @error('role')
                        <div class="alert alert-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-6 col-md-offset-3">
                        <button id="save" type="submit" class="btn btn-success">{{ __('custom.button.save') }}</button>
                        <a href="{{ route('users') }}" class="btn btn-primary">{{ __('custom.button.cancel') }}</a>
                    </div>
                </div>
                <br/>
            </form>
        </div>
    </div>
@endsection

@php
    if(old('role') !== null) $userRoles = old('role');
    $userRolesList = (!empty($userRoles)) ? implode("','", $userRoles) : "";
@endphp

@push('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            $('#role').val(['{!! $userRolesList !!}']);
            $('#role').trigger('change'); // Notify any JS components that the value changed
        })
    </script>
@endpush
