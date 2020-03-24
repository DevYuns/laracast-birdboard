<?php

namespace App\Http\Controllers;

use App\Project;
use App\Task;
use Illuminate\Http\Request;

class projectTasksController extends Controller
{
    public function store(Project $project)     // Route에서 wildcard로 변수를 가져오니까.. 주입가능
    {
        $this->authorize('update', $project);

        request()->validate(['body' => 'required']);

        $project->addTask(request('body'));

        return redirect($project->path());
    }

    public function update(Project $project, Task $task)
    {
        $this->authorize('update', $task->project);

        $task->update(request()->validate(['body' => 'required']));

        request('completed') ? $task->complete() : $task->incomplete();

        return redirect($project->path());
    }

}
