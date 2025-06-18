<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Events\UsersEvent;

use App\Models\EventUser;

class EventUserController extends Controller
{

    public function user_location(Request $request){
        $Validation = Validator::make($request->all(),[
            'user_location' => 'required|boolean',
            'event_id' => 'required|exists:events,id',
        ]);
        if($Validation->fails()){
            return response()->json($Validation->errors(),422);
        }

        $user_id = $request->user()->id;
        $user_count = EventUser::
        where('event_id', $request->event_id)
        ->count();
        broadcast(new UsersEvent($user_count, $request->user_location,
        $user_id, $request->event_id));

        return response()->json([
            'success' => 'You add data success'
        ]);
    }
}
