<?php

namespace App\Http\Controllers;

use Spatie\Activitylog\Models\Activity;

class ActivityLogController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $activities = Activity::orderBy('id','desc')->paginate(10);

        return view('activity-logs.index', compact('activities'));
    }

    /**
     * Display the specified resource.
     *
     * @param  Activity  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $activity = Activity::find($id);

        return view('activity-logs.show', compact('activity'));
    }

}
