<?php

namespace App\Services;

use App\DTO\ProjectDTO;
use App\Helpers\File;
use App\Repositories\ProjectRepository;

final class ProjectManagerService extends ServiceCore
{

    private ProjectRepository $projectRepository;

    public function __construct
    (
        ProjectRepository $projectRepository
    )
    {
        $this->projectRepository = $projectRepository;
    }

    public function getIndex($data) : array
    {
        $this->data = $data;

        $this->projects = $this->projectRepository->all();

        return $this->data;
    }

    public function setStore($request, $data) : array
    {

        $this->data = $data;
        $this->project = $this->projectRepository->create(ProjectDTO::getArray($request->all()));
        return $this->data;
    }


}
