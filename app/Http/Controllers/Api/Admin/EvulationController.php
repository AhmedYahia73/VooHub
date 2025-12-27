<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Evaulation;

use App\Image;

class EvulationController extends Controller
{
    public function __construct(private Evaulation $evaulation){}
    use Image;
    
    public function view(Request $request){
        $evaulations = $this->evaulation
        ->get()
        ->map(function($item){
            return [
                "id" => $item->id,
                "name" => $item->name,
                "title" => $item->title,
                "image_link" => $item->image_link,
                "evaulation" => $item->evaulation,
            ];
        });

        return response()->json([
            "evaulations" => $evaulations,
        ]);
    }
    
    public function create(Request $request){
        $validated = Validator::make($request->all(), [
            'name' => 'required',
            'title' => 'required',
            'image' => 'required',
            'evaulation' => 'required',
        ]);
        if ($validated->fails()) {
            return response()->json(['errors' => $validated->errors()], 422);
        }

        $image_path = $this->upload_image($request, 'image', 'admin/evaulation');
        $evaulations = $this->evaulation
        ->create([ 
            "name" => $request->name,
            "title" => $request->title,
            "image" => $image_path,
            "evaulation" => $request->evaulation,
        ]);
        
        return response()->json([
            "success" => "You add data success"
        ]);
    }
    
    public function modify(Request $request, $id){
        $evaluation = $this->evaulation
        ->where("id", $id)
        ->first();
        if($request->image){
            $image_path = $this->update_image($request, $evaluation->image, 'image', 'admin/evaulation');
        }
        $evaluation->update([
            "name" => $request->name ?? $evaluation->name,
            "title" => $request->title ?? $evaluation->title,
            "image" => $image_path ?? $evaluation->image,
            "evaulation" => $request->evaulation ?? $evaluation->evaulation,
        ]);

        return response()->json([
            "success" => "You update data success"
        ]);
    }
    
    public function delete(Request $request){
        $evaluation = $this->evaulation
        ->where("id", $id)
        ->first();
        $this->deleteImage($evaluation->image);
        $evaluation->delete();

        return response()->json([
            "success" => "You delete data success"
        ]);
    }
}
