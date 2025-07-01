<?php

namespace App\Http\Controllers\Api\Orgnization;

use App\Http\Controllers\Controller;
use App\Image;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserController extends Controller
{

    use Image;

    public function OrnizationPrfile(Request $request)
    {
        $Orgnization = $request->user()->with([
            'country:id,name',
            'city:id,name,country_id',
            'events' => function($query){
                $query->where('date', '<', date('Y-m-d'))
                ->orWhere('date', date('Y-m-d'))
                ->where('end_time', '<=', date('H:i:s'));
            },
            'tasks' => function($query){
                $query->where('date', '<', date('Y-m-d'))
                ->orWhere('date', date('Y-m-d'))
                ->where('start_time', '<=', date('H:i:s'));
            },
            'projects',
        ])->find($request->user()->id);
        return response()->json([
            'message' => 'User profile retrieved successfully',
            'Orgnization' => $Orgnization,
        ]);
    }

    public function editOrgnizationProfile(Request $request){
        $user = $request->user();
        $validation = Validator::make($request->all(), [
            'name' => 'nullable|string',
            'email' => ['nullable', 'email', Rule::unique('users')->ignore($request->user()->id)],
            'phone' => ['nullable', Rule::unique('users')->ignore($request->user()->id),],
            'password' => 'nullable|min:8',
            'avatar_image'=> 'nullable'
        ]);

        if ($validation->fails()) {
            return response()->json($validation->errors(), 422);
        }

        $user->update([
            'country_id' => $request->country_id?? $user->country_id,
            'city_id' => $request->city_id?? $user->city_id,
            'name' => $request->name?? $user->name,
            'email' => $request->email?? $user->email,
            'phone' => $request->phone?? $user->phone,
            'birth' => $request->bithdate?? $user->bithdate,
            'gender' => $request->gender?? $user->gender,
            'password' => $request->password ? Hash::make($request->password) : $user->password,
            'avatar_image' => $request->avatar_image ? $this->storeBase64Image($request->avatar_image, 'Orgnization/image') : $user->avatar_image,
        ]);
        return response()->json([
            'message' => 'User profile updated successfully',
            'Orgnization' => $user,
        ]);
    }


    public function getOrgnizationUsers(Request $request){
        $orgnization = $request->user();
        $users = User::where('role', 'user')
        ->where('orgnization_id', $orgnization->id)
        ->with(['country:name,id', 'city:name,id', 'user_papers','orgnization'
        , 'tasks', 'events'])->get();
        $data =[
            'users' => $users,
        ];
        return response()->json($data, 200);
    }

    public function getUser($id){
        $user = User::with(['country:name,id', 'city:name,id', 'user_papers','orgnization', 'user_events', 'user_tasks'])->findOrFail($id);
        $data =[
            'user' => $user,
        ];
        return response()->json($data, 200);
    }

    public function addUser(Request $request){
        $Orgnization = $request->user();
        $validation = Validator::make($request->all(), [
            'country_id' => 'required|exists:countries,id',
            'city_id' => 'required|exists:cities,id',
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|unique:users,phone',
            'password' => 'required|min:8',
            'bithdate' => 'nullable|date',
            'gender' => 'in:male,female',
        ]);

        if ($validation->fails()) {
            return response()->json($validation->errors(), 422);
        }

        $user = User::create([
            'orgnization_id' => $Orgnization->id,
            'country_id' => $request->country_id,
            'city_id' => $request->city_id,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'birth' => $request->bithdate,
            'gender' => $request->gender,
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

    public function deleteUser($id){
        $user = User::find($id);
        $user->delete();
        return response()->json([
            'message' => 'User deleted successfully',
        ]);
    }
}
