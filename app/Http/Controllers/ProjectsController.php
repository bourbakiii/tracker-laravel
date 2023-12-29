<?php

namespace App\Http\Controllers;

use App\Helpers\ResponsesHelper;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProjectsController extends Controller
{
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'description' => 'required|string',
        ]);
        if ($validator->fails()) return ResponsesHelper::validationErrors($validator->errors());
        try {
            $project = Project::create($request->all());
            return ResponsesHelper::success("Project created", 200, $project);
        } catch (\Exception $e) {
            return $e;
            return ResponsesHelper::error("Something wrong", 400, $e);
        }
    }

    public function getById($id)
    {
        try {
            if (!$project = Project::where('id', $id)->first()) return ResponsesHelper::error("Project not founded", 404);
            return ResponsesHelper::success("Project created", 200, $project);
        } catch (\Exception $e) {
            return ResponsesHelper::error("Something wrong", 400, $e);
        }
    }

    public function getAll()
    {
        try {
            return ResponsesHelper::success("Projects getted", 200, Project::all());
        } catch (\Exception $e) {
            return ResponsesHelper::error("Something wrong", 400, $e);
        }
    }

    public function delete($id)
    {
        try {
            if (!$project = Project::where('id',$id)->first()) {
                return ResponsesHelper::error("Project not founded", 404);
            }
            $project->delete();
            return ResponsesHelper::success("Project deleted", 200);
        } catch (\Exception $e) {
            return ResponsesHelper::error("Something wrong", 400, $e);
        }
    }

    public function edit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'description' => 'required|string',
        ]);
        if ($validator->fails()) return ResponsesHelper::validationErrors($validator->errors());
        try {
            if (!$project = Project::where('id', $request->get('id'))->first()) {
                return ResponsesHelper::error("Project not founded", 404);
            }
            $project->update($request->all());
            $project->save();
            return ResponsesHelper::success("Project edited", 200, $project);
        } catch (\Exception $e) {
            return ResponsesHelper::error("Something wrong", 400, $e);
        }
    }
}
