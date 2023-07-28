<?php

namespace App\Repositories;

use App\Contracts\AvailableProjectsRepositoryInterface;
use App\DTO\ProjectDTO;
use App\Models\Project;

final class AvailableProjectsRepository implements AvailableProjectsRepositoryInterface
{
    public function __construct() {}

    public function availableProjects() : array
    {
        $projects = Project::all()->toArray();
        return array_map(function(array $row) use ($projects){
           $availableProjects = ProjectDTO::getArray($projects);
           $availableProjects['id'] = $row['id'];
           $availableProjects['name'] = $row['name'];
           $availableProjects['image'] = $row['image'];
           return $availableProjects;
        },$projects);
    }
}
