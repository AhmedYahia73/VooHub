<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Setting;

class PolicyController extends Controller
{
    public function __construct(private Setting $settings){}

    public function view(Request $request){
        $policy = $this->settings
        ->where('name', 'policy')
        ->orderByDesc('id')
        ->first();

        return response()->json([
            'policy' => $policy
        ]);
    }

    public function update(Request $request){
        $Validation = FacadesValidator::make($request->all(), [
            'policy' => 'required',
        ]);
        if ($Validation->fails()) {
            return response()->json([
                'errors' => $Validation->errors()
            ], 400);
        }

        $policy = $this->settings
        ->where('name', 'policy')
        ->orderByDesc('id')
        ->first();

        if (empty($policy)) {
            $this->settings
            ->create([
                'name' => 'policy',
                'value' => $request->policy,
            ]);
        } 
        else {
            $policy->update([
                'value' => $request->policy,
            ]);
        }
        
        return response()->json([
            'success' => 'You update data success',
        ]);
    }
}
