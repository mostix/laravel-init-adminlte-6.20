@extends('layouts.admin')

@section('title')
    {{__('custom.add')}} {{trans_choice('custom.roles', 1)}}
@endsection

@section('header')
    <ol class="breadcrumb">
        <li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i> {{__('custom.home')}}</a></li>
        <li><a href="{{route('admin.roles')}}"><i class="fa fa-users"></i> {{trans_choice('custom.roles', 2)}}</a></li>
        <li class="active">{{__('custom.add')}} {{trans_choice('custom.roles', 1)}}</li>
    </ol>
@endsection

@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title my-2">{{__('custom.add')}} {{trans_choice('custom.roles', 1)}}</h3>

            <form action="{{ route('admin.roles.store') }}" method="post" role="form" id="form"
                  class="form-horizontal form-groups-bordered">
                @csrf

                <div class="form-group">
                    <label class="col-sm-3 control-label" for="name">{{ __('validation.attributes.name') }} <span
                            class="required">*</span></label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}">
                        @error('name')
                        <div class="alert alert-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-6 col-md-offset-3">
                        <button id="save" type="submit" class="btn btn-success">{{ __('custom.save') }}</button>
                        <a href="{{ route('admin.roles') }}"  class="btn btn-primary">{{ __('custom.cancel') }}</a>
                    </div>
                </div>
                <br/>
            </form>
        </div>
    </div>
@endsection
