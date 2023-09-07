<?php

namespace App\Http\Controllers\Api;

//use App\ViewModels\MyHoliday\BookingViewModel;
use App\Http\Controllers\Controller as BaseController;
use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Requests\CreateTaskRequest;

class TaskController extends BaseController
{
    /**
     * Get all tasks currently in the DB (not including those marked as deleted)
     * @return \Illuminate\Http\JsonResponse
     */
    public function getTasks(): \Illuminate\Http\JsonResponse
    {
        $tasks = Task::all();
        return response()->json(['data' => $tasks]);
    }

    /**
     * Write the submitted task to the DB
     * Validated by CreateTaskRequest
     * @return \Illuminate\Http\JsonResponse
     */
    public function createTask(CreateTaskRequest $request): \Illuminate\Http\JsonResponse
    {
        $data = Task::create($request->all());
        return response()->json(['status' => true, 'data' => $data], 201);
    }

    /**
     * Update the given task to be 'completed' in the DB
     * @return \Illuminate\Http\JsonResponse
     */
    public function completeTask(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $task = Task::findorfail($request->id);

            $task->update(['completed' => true]);
            return response()->json([
                'status' => true
            ], 201);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Task not found'
            ], 404);
        }
    }

    /**
     * Delete the given task from the DB
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteTask(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $task = Task::findorfail($request->id);

            $task->delete();
            return response()->json([
                'status' => true
            ], 201);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Task not found'
            ], 404);
        }
    }
}
