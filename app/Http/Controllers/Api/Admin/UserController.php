<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Shakwa;
use App\Models\Suggest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserController extends Controller
{


    public function getUsers(){
        $users = User::where('role', 'user')
        ->with(['country:name,id', 'city:name,id', 'user_papers','orgnization'])->get();
        $data =[
            'users' => $users,
        ];
        return response()->json($data, 200);
    }

    public function getUser($id){
        $user = User::with(['country:name,id', 'city:name,id', 'user_papers','orgnization'
        , 'user_events', 'user_tasks'])->findOrFail($id);
        $data =[
            'user' => $user,
        ];
        return response()->json($data, 200);
    }

    public function addUser(Request $request){
        $validation = Validator::make($request->all(), [
            'country_id' => 'required|exists:countries,id',
            'city_id' => 'required|exists:cities,id',
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|unique:users,phone',
            'account_status' => 'required|in:active,inactive',
            'password' => 'required|min:8',
            'bithdate' => 'nullable|date',
            'gender' => 'in:male,female',
        ]);

        if ($validation->fails()) {
            return response()->json($validation->errors(), 422);
        }

        $user = User::create([
            'country_id' => $request->country_id,
            'city_id' => $request->city_id,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'birth' => $request->bithdate,
            'gender' => $request->gender,
            'account_status' => $request->account_status,
            'role' => 'user',
        ]);

        return response()->json([
            'message' => 'User created successfully',
            'user' => $user,
        ]);
    }

    public function updateUser(Request $request, $id){
        $validation = Validator::make($request->all(), [
            'country_id' => 'nullable|exists:countries,id',
            'city_id' => 'nullable|exists:cities,id',
            'account_status' => 'nullable|in:active,inactive',
            'name' => 'nullable|string',
            'email' => ['nullable', 'email', Rule::unique('users')->ignore($id)],
            'phone' => ['nullable', Rule::unique('users')->ignore($id),],
            'bithdate' => 'nullable|date',
            'gender' => 'nullable|in:male,female',
        ]);

        if ($validation->fails()) {
            return response()->json($validation->errors(), 422);
        }

        $user = User::findOrFail($id);
        $user->update([
            'country_id' => $request->country_id?? $user->country_id,
            'city_id' => $request->city_id?? $user->city_id,
            'name' => $request->name?? $user->name,
            'email' => $request->email?? $user->email,
            'phone' => $request->phone?? $user->phone,
            'birth' => $request->bithdate?? $user->bith,
            'gender' => $request->gender?? $user->gender,
            'account_status' => $request->account_status ?? $user->account_status,
        ]);

        return response()->json([
            'message' => 'User updated successfully',
        ]);
    }

    public function status(Request $request, $id){
        $validation = Validator::make($request->all(), [
            'account_status' => 'required|in:active,inactive',
        ]);
        if ($validation->fails()) {
            return response()->json($validation->errors(), 422);
        }
        $user = User::findOrFail($id);
        $user->update([
            'account_status' => $request->account_status,
        ]);
        
        return response()->json([
            'success' => 'You change status successfully',
        ]);
    }

    public function deleteUser($id){
        $user = User::find($id);
        $user->delete();
        return response()->json([
            'message' => 'User deleted successfully',
        ]);
    }

    public function getShakawy(){
        $shakawy = Shakwa::with(['user:id,name'])->get();
        return response()->json([
            'shakawy' => $shakawy,
        ]);
    }

    public function getSuggests(){
        $events = Suggest::with(['user:id,name','event','task'])
        ->whereNotNull('event_id')
        ->where('status', '!=', 'read')->get();
        $tasks = Suggest::with(['user:id,name','event','task'])
        ->whereNotNull('task_id')
        ->where('status', '!=', 'read')->get();

        return response()->json([
            'events' => $events,
            'tasks' => $tasks,
        ]);
    }
}
