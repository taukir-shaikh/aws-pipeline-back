<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PipelineController extends Controller
{
    public function getPipelineAvailability()
    {
       try {

       } catch (\Exception $e) {
       }
    }

    public function getServices()
    {
       try {
         $pipelines = DB::table('pipelines')->get();
         if($pipelines->isEmpty()) {
            return response()->json(['message' => 'No pipelines found'], 404);
         }

         $data = [];
         foreach ($pipelines as $pipeline) {
            $record = DB::table('pipelines')
            ->join('pipeline_access', 'pipelines.id', '=', 'pipeline_access.pipeline_id')
            ->join('users', 'pipeline_access.user_id', '=', 'users.id')
            ->where('pipeline_id', $pipeline->id)->get();
            if($record->isEmpty()) {
                $data[] = [
                    'id' => $pipeline->id,
                    'name' => $pipeline->name,
                    'status' => 'available'
                ];
            }else {
                $data[] = [
                    'id' => $pipeline->id,
                    'name' => $pipeline->name,
                    'status' => 'unavailable',
                    'accessed_user' => $record[0]->name,
                    'branch' => $record[0]->branch_name,
                ];
            }
            return response()->json(['pipelines' => $data], 200);
         }
       } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while fetching pipelines', 'message' => $e->getMessage()], 500);
       }
    }
}
