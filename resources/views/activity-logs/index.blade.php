@extends('layouts.admin')

@section('title')
    {{trans_choice('custom.activity_logs', 2)}}
@endsection

@section('header')
    <ol class="breadcrumb">
        <li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i> {{__('custom.dashboard')}}</a></li>
        <li class="active">{{trans_choice('custom.activity_logs', 2)}}</li>
    </ol>
@endsection

@section('content')<!-- Default box -->
<div class="box box-success hidden">
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
                    <a href="{{route('activity-logs')}}" class="btn btn-sm btn-default"> {{__('custom.clear')}}</a>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="box box-info">
    <div class="box-body">
        <table class="table table-bordered" width="100%" cellspacing="0">
            <thead>
            <tr>
                <th>ID</th>
                <th>{{__('custom.activity_log_date')}}</th>
                <th>{{__('custom.activity_log_model')}}</th>
                <th>{{__('custom.activity_log_action')}}</th>
                <th>{{__('custom.activity_log_subject')}}</th>
                <th>{{__('custom.activity_log_subject_id')}}</th>
                <th>{{__('custom.activity_log_causer')}}</th>
                <th>{{__('custom.activity_log_causer_id')}}</th>
                <th>{{__('custom.actions')}}</th>
            </tr>
            </thead>
            <tbody>
            @if(isset($activities) && count($activities))
                @foreach($activities as $activity)
                    @php
                        $subject = $activity->subject_type::find($activity->subject_id);
                        $subjectName = "Няма данни за Обекта, може би е бил изтрит";
                        if($subject) {
                          $subjectName = ($subject->first_name)
                                            ? $subject->first_name." ".$subject->last_name
                                            : ($subject->name ? $subject->name : $subject->title);
                        }
                        $causerName = "Няма данни за Дееце, може би е бил изтрит";
                        if($activity->causer) {
                          $causerName = $activity->causer->first_name." ".$activity->causer->last_name;
                          if(mb_strlen($causerName) < 2) $causerName = $activity->causer->username;
                        }
                    @endphp
                    <tr>
                        <td>{{$activity->id}}</td>
                        <td>{{$activity->created_at}}</td>
                        <td>{{ __($activity->subject_type::MODULE_NAME) }}</td>
                        <td>{{__('custom.'.$activity->description)." ".__('custom.of')." ".trans_choice('custom.'.$activity->log_name, 1)}}</td>
                        <td>{{$subjectName}}</td>
                        <td>{{$activity->subject_id}}</td>
                        <td>{{$causerName}}</td>
                        <td>{{$activity->causer_id}}</td>
                        <td>
                            <a href="{{route('activity-logs.show',$activity->id)}}"
                               class="btn btn-sm btn-info"
                               data-toggle="tooltip"
                               title="{{__('custom.view')}}">
                                <i class="fa fa-search"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            @endif
            </tbody>
        </table>
        @if(isset($activities) && count($activities))
            {{ $activities->links() }}
        @endif
    </div>
</div>

@endsection


