<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\Request as ModelsRequest;
use Illuminate\Http\Request;

use App\Models\EventVolunteer;
use App\Models\TaskVolunteer;

class HistoryController extends Controller
{


    public function getHistoryAttend(){
        $user = request()->user();
        $userId = $user->id;
        $historytask = ModelsRequest::where('user_id', $userId)
        ->where('request_type', 'task')
            ->with([
            'user:id,name,email',
            'task',
            // 'event.city',
            // 'event.country',
            // 'event.zone',
            // 'event.event_benfits',
            // 'event.event_requirments',
            'task.from_zone:id,name,city_id,country_id',
            'task.to_zone:id,name,city_id,country_id',
            'orgnization:id,name'
            ])
            ->get();

        $historyevent = ModelsRequest::where('user_id',$userId)
        ->where('request_type','event')
        ->with([
            'user:id,name,email',
            'event.city',
            'event.country',
            'event.zone',
            'event.event_benfits',
            'event.event_requirments',
            'orgnization:id,name'
        ])->get();

        return response()->json([
            'historyTask'=>$historytask,
            'historyEvent'=>$historyevent
        ]);

    }

    public function getHistoryLost(){
        $user = request()->user();
        $userId = $user->id;
        $historyLost = ModelsRequest::where('user_id', $userId)
            ->where('status', 'lost')
            ->with(['user:id,name,email',
            'task',
            'event.city',
            'event.country',
            'event.zone',
            'event.event_benfits',
            'event.event_requirments',
            'task.from_zone:id,name,city_id,country_id',
            'task.to_zone:id,name,city_id,country_id',
            'orgnization:id,name'
            ])
            ->get();

        return response()->json(['historyLost' => $historyLost], 200);
    }

    public function events(Request $request){
        // /api/user/upcomingEvents
        $events = EventVolunteer::
        with('event')
        ->where('user_id', $request->user()->id)
        ->where('status', 'accepted')
        ->get()
        ->map(function($item){
            return [
                'qr_code' => $item->qr_code_link,
                'event' => $item?->event?->name,
                'date' => $item?->event?->date,
                'start_time' => $item?->event?->start_time,
                'end_time' => $item?->event?->end_time,
                'event_id' => $item?->event?->name,
            ];
        });

        return response()->json([
            'events' => $events,
        ]);
    }

    public function tasks(Request $request){
        // /api/user/upcomingTasks
        $events = TaskVolunteer::
        with('task')
        ->where('user_id', $request->user()->id)
        ->where('status', 'accepted')
        ->get()
        ->map(function($item){
            return [
                'qr_code' => $item->qr_code_link,
                'event' => $item?->event?->name,
                'date' => $item?->event?->date,
                'start_time' => $item?->event?->start_time,
                'end_time' => $item?->event?->end_time,
                'event_id' => $item?->event?->name,
            ];
        });

        return response()->json([
            'events' => $events,
        ]);
    }
}
