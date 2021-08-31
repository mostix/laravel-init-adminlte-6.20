@extends('layouts.admin')

@section('title')
    {{trans_choice('custom.activity_logs', 2)}}
@endsection

@section('header')
    <ol class="breadcrumb">
        <li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i> {{__('custom.home')}}</a></li>
        <li><a href="{{route('admin.activity-logs')}}"><i
                    class="fa fa fa-clock-o"></i> {{trans_choice('custom.activity_logs', 2)}}</a></li>
        <li class="active">{{__('custom.view')}}</li>
    </ol>
@endsection

@section('content')<!-- Default box -->
<div class="box box-info">
    <div class="box-body">
        <table class="table table-bordered" width="100%" cellspacing="0">
            <tbody>
            @php
                $subject = $activity->subject_type::find($activity->subject_id);
                if($subject) {
                  $subjectName = ($subject->first_name)
                                    ? $subject->first_name." ".$subject->last_name
                                    : ($subject->name ? $subject->name : $subject->title);
                }
                else $subjectName = "Няма данни за обекта, вероятно е бил изтрит";
                $causerName = "Няма данни за Дееце, може би е бил изтрит";
                if($activity->causer) {
                  $causerName = $activity->causer->first_name." ".$activity->causer->last_name;
                }
            @endphp
            <tr>
                <td>{{__('custom.activity_log_date')}}</td>
                <td>{{$activity->created_at}}</td>
            </tr>
            <td>{{__('custom.activity_log_model')}}</td>
            <td>{{$activity->subject_type}}</td>
            </tr>
            <tr>
                <td>{{__('custom.activity_log_action')}}</td>
                <td>{{__('custom.'.$activity->description)." ".__('custom.of')." ".trans_choice('custom.'.$activity->log_name, 1)}}</td>
            </tr>
            <tr>
                <td>{{__('custom.activity_log_subject')}}</td>
                <td>{{trans_choice('custom.'.$activity->log_name, 1).": ". $subjectName}}</td>
            </tr>
            <tr>
                <td>{{__('custom.activity_log_causer')}}</td>
                <td>{{$causerName}}</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td style="background: #212c65;color:#fff;">{{__('custom.activity_log_new_state')}}</td>
                <td style="background: #212c65;color:#fff;">{{__('custom.activity_log_old_state')}}</td>
            </tr>
            @if($activity->log_name == "employees")
                @includeIf('activity-logs.employees', ['model' => $activity->subject_type])
            @elseif($activity->log_name == "scenarios")
                @includeIf('activity-logs.scenarios', ['model' => $activity->subject_type])
            @else
                <tr>
                    <td>
                        @foreach($activity->changes['attributes'] as $key => $value)
                            @if($key != "updated_at")
                                <p>{{ trans_choice('custom.'.$key, 1) }} : {{ $value }}</p>
                            @endif
                        @endforeach
                    </td>
                    <td>
                        @if(isset($activity->changes['old']))
                            @foreach($activity->changes['old'] as $key => $value)
                                @if($key != "updated_at")
                                    <p>{{ trans_choice('custom.'.$key, 1) }} : {{ $value }}</p>
                                @endif
                            @endforeach
                        @endif
                    </td>
                </tr>
            @endif
            </tbody>
        </table>
    </div>
</div>

@endsection
