<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\AdminRequest;

class NotificationRequestController extends Controller
{
    public function __construct(private AdminRequest $admin_request){}

    public function notification_num(Request $request){
        $requests_count = $this->admin_request
        ->where('view_notification', 0);
        if ($request->user()->role == 'organization') {
            $requests_count = $requests_count
            ->where('orgnization_id', $request->user()->id);
        }
        $requests_count = $requests_count->count();

        return response()->json([
            'requests_count' => $requests_count,
        ]);
    }

    public function view_notification(Request $request){
        $Validation = Validator::make($request->all(), [
            'notification_num'=>'required|numeric',
        ]);
        if($Validation->fails()){
            return response()->json(['message'=>$Validation->errors()], 422);
        }

        $requests_query = $this->admin_request
        ->where('view_notification', 0);
        if ($request->user()->role == 'organization') {
            $requests_query = $requests_query
            ->where('orgnization_id', $request->user()->id);
        }
        $requests_ids = $requests_query->limit($request->notification_num)?->pluck('id');
        $this->admin_request
        ->whereIn('id', $requests_ids)
        ->update([
            'view_notification' => 1
        ]);

        return response()->json([
            'success' => 'You view notification success'
        ]);
    }

    public function view_request(Request $request, $id){
        $requests_count = $this->admin_request
        ->where('id', $id)
        ->update([
            'view_request' => 1
        ]);
        
        return response()->json([
            'success' => 'You view request success'
        ]);
    }
}
