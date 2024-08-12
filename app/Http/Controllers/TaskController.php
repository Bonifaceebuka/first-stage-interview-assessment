<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Task;
use App\Models\User;
use App\Http\Requests\TaskRequest;
use Illuminate\Support\Collection;
use App\Http\Resources\TaskResource;
use Illuminate\Support\Facades\Auth;
use App\Http\Traits\HttpResponseTrait;

class TaskController extends Controller
{
     // This Trait handles the formatting of the JSON response on the app
     use HttpResponseTrait;
    public function index()
    {
        $message = null;
        $status_code = null;
        $data = null;
        try{
            $creatorId = Auth::guard('sanctum')->user()->id;
            $data_per_page = config("custom_config.pagination_limit");
            $tasks = Task::where('created_by', '=', $creatorId);
            if($tasks->count() == 0){
                $message = null;
                $data = [];
                $status_code = 200;
                return $this->http_response($message, $status_code, $data);
            }

            $data = TaskResource::collection($tasks->paginate($data_per_page))->response()->getData();
            $message = null;
            $status_code = 200;

            return $this->http_response($message, $status_code, $data);
        }
        catch (\Exception $e) {
            $message = "Something went wrong";
            $status_code = 500;
            return $this->http_response($message, $status_code);
        }
    }

    public function store(TaskRequest $request)
    {
        try{
            $user = Auth::guard('sanctum')->user();

            $task             = new Task();
            $task->title       = $request->title;
            $task->description       = isset($request->description) ? $request->description : null;
            $task->planned_date       = isset($request->planned_date) ? $request->planned_date : null;
            $task->status       = $request->status;
            $task->created_by       = $user->id;
            $task->save();
            
            $message = 'Task ' . $task->name .' successfully created';
            $status_code = 201;
            return $this->http_response($message, $status_code);
        }catch (\Exception $e) {
            $message = "Something went wrong";
            $status_code = 500;
            return $this->http_response($message, $status_code);
        }

    }

    public function show($task)
    {
        try{
            $user = Auth::guard('sanctum')->user();
            $task =  Task::where('id', $task)->where('created_by',$user->id)->first();
            if($task == null){
                $status_code = 404;
                $message = "Task not found!";
                return $this->http_response($message, $status_code);
            }

            $data = TaskResource::make($task);
            $status_code = 200;
            $message = null;
            return $this->http_response($message, $status_code, $data);
        }catch (\Exception $e) {
            $message = "Something went wrong";
            $status_code = 500;
            return $this->http_response($message, $status_code);
        }
    }

    public function update(TaskRequest $request, $task)
    {
        try{
            $user = Auth::guard('sanctum')->user();
            $task =  Task::where('id', $task)->where('created_by',$user->id)->first();
            if($task == null){
                $status_code = 404;
                $message = "Task not found!";
                return $this->http_response($message, $status_code);
            }

            $task->title       = $request->title;
            $task->description       = isset($request->description) ? $request->description : null;
            $task->planned_date       = isset($request->planned_date) ? $request->planned_date : null;
            $task->status       = $request->status;
            if($request->status === "completed"){
                $task->completed_at       = Carbon::now();
            }
            $task->save();

            $status_code = 200;
            $message = 'Task ' . $task->name .' successfully updated.';
            return $this->http_response($message, $status_code);
        }catch (\Exception $e) {
            $message = "Something went wrong";
            $status_code = 500;
            return $this->http_response($message, $status_code);
        }

    }


    public function destroy($task)
    {
        try{
            $user = Auth::guard('sanctum')->user();
            $task =  Task::where('id', $task)->where('created_by',$user->id)->first();
            if($task == null){
                $status_code = 404;
                $message = "Task not found!";
                return $this->http_response($message, $status_code);
            }

            $task->delete();
            $status_code = 200;
            $message = 'Task successfully deleted.';
            return $this->http_response($message, $status_code);

        }catch (\Exception $e) {
            $message = "Something went wrong";
            $status_code = 500;
            return $this->http_response($message, $status_code);
        }
    }
}
