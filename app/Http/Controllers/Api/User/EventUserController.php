<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
        
    }
}
