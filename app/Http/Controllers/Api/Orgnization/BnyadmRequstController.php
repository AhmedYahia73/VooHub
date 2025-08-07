<?php

namespace App\Http\Controllers\Api\Orgnization;

use App\Http\Controllers\Controller;
use App\Models\UserPaper;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BnyadmRequstController extends Controller
{


    public function getBnyadmRequstList(Request $request){
        $Orgnization_id = $request->user()->id;
        $bnyadm = UserPaper::where('orgnization_id', $Orgnization_id)
            ->where('status', 'pending')
            ->with([
            'user:id,name,email,phone',
            'orgnization:id,name,email,phone',
        ])->get();
        return response()->json([
            'message' => 'Bnyadm requst list retrieved successfully',
            'data' => $bnyadm
        ]);
    }

    public function getBnyadmRequstDetails($id){
        $bnyadm = UserPaper::with([
            'user:id,name,email,phone',
            'orgnization:id,name,email,phone',
        ])->find($id);
        if ($bnyadm) {
            return response()->json([
                'message' => 'Bnyadm requst details retrieved successfully',
                'data' => $bnyadm
            ]);
        } else {
            return response()->json([
                'message' => 'Bnyadm requst not found'
            ], 404);
        }
    }

    public function acceptBnyadmRequst($id){
        $bnyadm = UserPaper::find($id);
        if ($bnyadm) {
            $bnyadm->update(['status' => 'accepted']);
            User::where('id', $bnyadm->user_id)
            ->update([
                'orgnization_id' => $bnyadm->orgnization_id,
            ]);
            return response()->json([
                'message' => 'Bnyadm requst accepted successfully',
                'data' => $bnyadm
            ]);
        } else {
            return response()->json([
                'message' => 'Bnyadm requst not found'
            ], 404);
        }
    }

    public function rejectBnyadmRequst($id){
        $bnyadm = UserPaper::find($id);
        if ($bnyadm) {
            $bnyadm->update(['status' => 'rejected']);
            return response()->json([
                'message' => 'Bnyadm requst rejected successfully',
                'data' => $bnyadm
            ]);
        } else {
            return response()->json([
                'message' => 'Bnyadm requst not found'
            ], 404);
        }
    }
    public function acceptGroup(Request $request){
        $validation = Validator::make($request->all(), [
            'ids' => 'required|array',
            'ids.*' => 'exists:user_papers,id',
        ]);
        if ($validation->fails()) {
            return response()->json($validation->errors(), 422);
        }
        foreach ($request->ids as $item) {
            $bnyadm = UserPaper::find($item); 
            $bnyadm->update(['status' => 'accepted']);
            User::where('id', $bnyadm->user_id)
            ->update([
                'orgnization_id' => $bnyadm->orgnization_id,
            ]);
        }
        return response()->json([
            'message' => 'Bnyadm requst accepted successfully',
        ]); 
    }

    public function rejectGroup(Request $request){
        $validation = Validator::make($request->all(), [
            'ids' => 'required|array',
            'ids.*' => 'exists:user_papers,id',
        ]);
        if ($validation->fails()) {
            return response()->json($validation->errors(), 422);
        }

        $bnyadm = UserPaper::
        whereIn('id', $request->ids)
        ->update(['status' => 'rejected']);

        return response()->json([
            'message' => 'Bnyadm requst rejected successfully',
        ]); 
    }
}
