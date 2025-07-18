<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\traits\Notifications;

use App\Models\Notification as NewNotification;
use App\Models\NotificationUser;
use App\Models\DeviceToken;
use App\Models\User;

class NotifictionUserController extends Controller
{
    public function __construct(private NewNotification $notification,
    private NotificationUser $notification_user, private User $user,
    private DeviceToken $device_token){}
    use Notifications;

    public function view(Request $request){
        $notifications = $this->notification
        ->where('user_id', $request->user()->id)
        ->with('users')
        ->get();
        $users = $this->user
        ->where('role', 'user')
        ->get();

        return response()->json([
            'notifications' => $notifications,
            'users' => $users,
        ]);
    }

    public function notification(Request $request, $id){
        $notification = $this->notification
        ->where('user_id', $request->user()->id)
        ->where('id', $id)
        ->with('users')
        ->first();

        return response()->json([
            'notification' => $notification,
        ]);
    }

    public function create(Request $request){
        $Validation = Validator::make($request->all(), [
            'title' => 'required',
            'notification' => 'required',
            'users' => 'required|array',
            'users.*' => 'required|exists:users,id',
        ]);
        if ($Validation->fails()) {
            return response()->json([
                'errors' => $Validation->errors()
            ], 422);
        }

        $notification = $this->notification
        ->create([
            'title' => $request->title,
            'notification' => $request->notification,
            'user_id' => $request->user()->id,
        ]);
        $notification->users()->attach($request->users);
        $tokens = $this->device_token
        ->whereIn('user_id', $request->users)
        ->pluck('token')->toArray();

        if(count($tokens) > 0){
            $this->sendNotificationToMany($tokens, $notification->title, $notification->notification);
        }
        return response()->json([
            'success' => 'You add data success'
        ]);
    }

    public function modify(Request $request, $id){
        $Validation = Validator::make($request->all(), [
            'title' => 'required',
            'notification' => 'required',
            'users' => 'required|array',
            'users.*' => 'required|exists:users,id',
        ]);
        if ($Validation->fails()) {
            return response()->json([
                'errors' => $Validation->errors()
            ], 422);
        }

        $notification = $this->notification
        ->where('id', $id)
        ->first();
        $notification->update([
            'title' => $request->title,
            'notification' => $request->notification,
            'user_id' => $request->user()->id,
        ]);
        $notification->users()->detach();
        $notification->users()->attach($request->users);
      
        $tokens = $this->device_token
        ->whereIn('user_id', $request->users)
        ->pluck('token')->toArray();
        if(count($tokens) > 0){
            $this->sendNotificationToMany($tokens, $notification->title, $notification->notification);
        }

        return response()->json([
            'success' => 'You update data success'
        ]);
    }

    public function delete(Request $request, $id){
        $notification = $this->notification
        ->where('id', $id)
        ->delete();

        return response()->json([
            'success' => 'You add data success'
        ]);
    }
}
