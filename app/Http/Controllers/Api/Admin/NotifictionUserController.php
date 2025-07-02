<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

use App\Models\Notification;
use App\Models\NotificationUser;
use App\Models\User;

class NotifictionUserController extends Controller
{
    public function __construct(private Notification $notification,
    private NotificationUser $notification_user, private User $user){}

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
            'notification' => $request->notification,
            'user_id' => $request->user()->id,
        ]);
        $notification->users->attach($request->users);

        return response()->json([
            'success' => 'You add data success'
        ]);
    }

    public function modify(Request $request, $id){
        $Validation = Validator::make($request->all(), [
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
        ->update([
            'notification' => $request->notification,
            'user_id' => $request->user()->id,
        ]);
        $notification->users->sync($request->users);

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
