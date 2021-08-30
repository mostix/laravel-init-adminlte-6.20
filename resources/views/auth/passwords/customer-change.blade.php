@extends('layouts.auth')

@section('content')
    <div class="card">
        <div class="card-header text-center mb-4"><h3>{{ __('custom.choose_password') }}</h3></div>

        <div class="card-body">
            <form method="POST" action="{{ route('customer-update-password', $customer->id) }}">
                @csrf

                <div class="form-group row mb-3">
                    <label class="col-sm-12 control-label" for="password">{{ __('validation.attributes.password') }}
                        <span class="required">*</span></label>
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <input type="password" name="password" class="form-control">
                        <i>{{ __('auth.password_format') }}</i>
                        @error('password')
                        <div class="alert alert-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group row mb-3">
                    <label class="col-sm-12 control-label"
                           for="password_confirmation">{{ __('validation.attributes.password_confirm') }} <span
                            class="required">*</span></label>
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <input type="password" name="password_confirmation" class="form-control">
                        @error('password_confirmation')
                        <div class="alert alert-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group row mb-0">
                    <div class="col-md-6 offset-md-4">
                        <button type="submit" class="btn btn-primary">
                            {{ __('custom.login') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
