<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProjectRequest;
use Illuminate\Http\Request;
use App\User;
use App\project;

class ProjectsController extends Controller
{
    public function index()
    {
        $projects = auth()->user()->accessibleProjects();

        return view('projects.index', compact('projects'));
    }

    public function show(Project $project)
    {
//        $project = Project::findOrFail(request('project'));
// routes안에서 첫번째 인자로 전달된 wildcard변수는 controller로 바로
//  전달되기 때문에, 메서드 안으로 injection할 수 있다. 따라서 위 코드가 필요없이 타입힌트를 이용하면 된다.

        $this->authorize('update', $project);
//        if (auth()->user()->isNot($project->owner)) {
//            abort(403);
//        }

        return view('projects.show', compact('project'));
    }

    public function create ()
    {
        return view('projects.create');
    }

    public function store ()
    {
        $project = auth()->user()->projects()->create($this->validateRequest());

        if (request()->has('tasks')) {
            foreach (request('tasks') as $task) {
                $project->addTask($task['body']);
            }
        }

        if (request()->wantsJson()) {
            return ['message' => $project->path()];
        }

        return redirect($project->path());
    }

    public function edit(Project $project)
    {
        return view('projects.edit', compact('project'));
    }

    public function update (UpdateProjectRequest $form)
    {
//        if (auth()->user()->isNot($project->owner)) {
//            abort(403);
//        }
        // php artisan make:policy policyName 실행하면 app\polices 폴더에 생성가능 거기에 권한 관련 파일넣고 쓸 수 있다.

//        $project->update($request->validated()
        $form->save();
        return redirect($form->path());
    }

    public function destroy(Project $project)
    {
        $this->authorize('manage', $project);

        $project->delete();
        return redirect('/projects');
    }

    protected function validateRequest()
    {
        return request()->validate([
            'title' => 'sometimes|required',
            'description' => 'sometimes|required',
            'notes' => 'nullable'
        ]);
    }
}
