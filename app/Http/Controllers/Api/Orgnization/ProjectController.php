<?php

namespace App\Http\Controllers\Api\Orgnization;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\OrganizationProject;

class ProjectController extends Controller
{
    public function __construct(private OrganizationProject $project){}

    public function view(Request $request){
        $projects = $this->project 
        ->where('organiztion_id', $request->user()->id)
        ->get();

        return response()->json([
            'projects' => $projects
        ]);
    }

    public function project(Request $request, $id){
        $project = $this->project
        ->where('id', $id)
        ->where('organiztion_id', $request->user()->id)
        ->first();

        return response()->json([
            'project' => $project
        ]);
    }

    public function create(Request $request){
        $validation = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required',
        ]);
        if ($validation->fails()) {
            return response()->json($validation->errors(), 422);
        }
        $projectRequest = $validation->validated();
        $projectRequest['organiztion_id'] = $request->user()->id;

        $project = $this->project
        ->create($projectRequest);

        return response()->json([
            'success' => 'You add data success'
        ]);
    }

    public function modify(Request $request, $id){
        $validation = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required',
        ]);
        if ($validation->fails()) {
            return response()->json($validation->errors(), 422);
        }
        $projectRequest = $validation->validated(); 
        $project = $this->project
        ->where('id', $id)
        ->where('organiztion_id', $request->user()->id)
        ->update($projectRequest);

        return response()->json([
            'success' => 'You update data success'
        ]);
    }

    public function delete(Request $request, $id){
        $project = $this->project
        ->where('id', $id)
        ->where('organiztion_id', $request->user()->id)
        ->delete();

        return response()->json([
            'success' => 'You delete data success'
        ]);
    }
}
