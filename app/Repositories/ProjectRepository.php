<?php

namespace App\Repositories;

use App\Helpers\Files;
use App\Models\Project;
use App\Repositories\Interfaces\ProjectRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

final class ProjectRepository implements ProjectRepositoryInterface
{

    protected Project $project;

    public function __construct(Project $project)
    {
        $this->project = $project;
    }

    public function all($columns = array('*')) : Collection
    {
        return $this->project->all($columns);
    }

    public function find($id, $columns = array('*'))
    {
        return $this->project->findOrFail($id, $columns);
    }

    public function create(array $input) : array
    {
        $result = [
            'status' => false,
            'data' => null,
        ];

        $project = new $this->project();

        if (isset($input['name']))
            $project->name = $input['name'];
        if (isset($input['image']))
            $project->image = Files::upload($input['image'],'project/images');

        $project->save();
        if($project->id) {
            $changed = $project->toArray();
            $result['status'] = true;
            $result['data'] = [
                'original' => [],
                'changed' => $changed
            ];
        }
        return $result;
    }

    public function destroy($id)
    {
        // TODO: Implement destroy() method.
    }

    public function update($id, array $input)
    {
        // TODO: Implement update() method.
    }
}
