<?php

namespace App\Http\Controllers;

use App\Events\TaskEvent;
use App\Models\Task;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Http\Request;

class TaskController extends Controller
{

    public function tasks(){
        return view('task.tasks',[
            'tasks' => Task::all(),
        ]);
    }

    public function getTasks (){
        return response()->json(Task::all());
    }

    public function create(Request $request){
        $task = Task::create([
            'task_name' => $request->task_name
        ]);

        event(new TaskEvent($task));
    }


    public static function index()
    {

        $schedule = new Schedule();
        return dd($schedule->dueEvents(app()));
    }


}
