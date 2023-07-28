<?php

namespace App\Http\Controllers;

use App\Helpers\Files;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\Project;
use App\Repositories\AvailableProjectsRepository;
use App\Services\ProjectManagerService;
use Illuminate\Http\RedirectResponse;

class ProjectController extends Controller
{

    public function __construct
    (
        private readonly ProjectManagerService $projectManagerService,
        private readonly AvailableProjectsRepository $projectsRepository
    ) {}

    public function index()
    {
        $projects = $this->projectsRepository->availableProjects();

        $this->data['projects'] = $projects;

        return view('projects.index', ['projects' => $this->data['projects']]);
    }

    public function create()
    {
        return view('projects.create');
    }

    public function store(StoreProjectRequest $request) : RedirectResponse
    {

        $this->projectManagerService->setStore($request,$this->data);

        return redirect()->route('projects.index');
    }

    public function edit(Project $project)
    {
        return view('projects.edit', compact('project'));
    }

    public function update(UpdateProjectRequest $request, Project $project)
    {
        $project->update($request->validated());

        return redirect()->route('projects.index');
    }

    public function destroy(Project $project)
    {
        $project->delete();

        return redirect()->route('projects.index');
    }
}
