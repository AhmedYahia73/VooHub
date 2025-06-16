<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class OrgnizationController extends Controller
{


    public function getOrgnization(){
        $orgnization = User::where('role', 'organization')
        ->with(['country:name,id', 'city:name,id',])->get();
        $data =[
            'orgnization' => $orgnization,
        ];
        return response()->json($data, 200);
    }

    public function addOrgnization(Request $request){
        $validation = Validator::make($request->all(), [
            'country_id' => 'required|exists:countries,id',
            'city_id' => 'required|exists:cities,id',
            'name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required',
            'password' => 'required|min:8',
            'account_status' => 'required|in:active,inactive',
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
            'account_status' => $request->account_status,
            'password' => Hash::make($request->password),
            'role' => 'organization',
        ]);
        $data =[
            'orgnization' => $user,
        ];
        return response()->json($data, 200);
    }

    public function updateOrgnization(Request $request, $id){
        $validation = Validator::make($request->all(), [
            'country_id' => 'nullable|exists:countries,id',
            'city_id' => 'nullable|exists:cities,id',
            'name' => 'nullable|string',
            'email' => 'nullable|email',
            'phone' => 'nullable',
            'account_status' => 'nullable|in:active,inactive',
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
            'account_status' => $request->account_status?? $user->account_status,
        ]);

        return response()->json([
            'message' => 'Orgnization updated successfully',
        ]);
    }

    public function status(Request $request){
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

    public function deleteOrgnization($id){
        $user = User::findOrFail($id);
        $user->delete();
        return response()->json([
            'message' => 'Orgnization deleted successfully',
        ]);
    }
    public function getOrgnizationById($id){
        $orgnization = User::where('role', 'orgnization')
        ->with(['country:name,id', 'city:name,id','user_papers'])->findOrFail($id);
        $data =[
            'orgnization' => $orgnization,
        ];
        return response()->json($data, 200);
    }
}
